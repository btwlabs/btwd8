<?php

namespace Drupal\shipstation_commerce\Plugin\rest\resource;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Request;
use Drupal\core\Password\PasswordInterface;
use \Drupal\Core\Cache\CacheableMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Drupal\shipstation_commerce\ShipstationData;
use \Datetime;
use \DatetimeZone;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "shipstation_resource",
 *   label = @Translation("Shipstation resource"),
 *   uri_paths = {
 *     "canonical" = "/shipstation-api",
 *     "https://www.drupal.org/link-relations/create" = "/shipstation-api"
 *   }
 * )
 */
class ShipstationResource extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The request object that contains the parameters.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * A password hashing interface.
   *
   * @var \Drupal\core\Password\PasswordInterface
   */
  protected $passwordHasher;

  /**
   * The serializer which serializes the views result.
   *
   * @var \Symfony\Component\Serializer\Serializer
   */
  protected $serializer;

  /**
   * Constructs a new ShipstationResource object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request object.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A current user instance.
   * @param \Drupal\Core\Password\PasswordInterface $password_hasher
   *   A password manager interface.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user,
    Request $request,
    PasswordInterface $password_hasher,
    SerializerInterface $serializer)

  {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger, $password_hasher, $serializer);
    $this->request = $request;
    $this->currentUser = $current_user;
    $this->passwordHasher = $password_hasher;
    $this->serializer = $serializer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('shipstation_commerce'),
      $container->get('current_user'),
      $container->get('request_stack')->getCurrentRequest(),
      $container->get('password'),
      $container->get('serializer')
    );
  }

  /**
   * Responds to POST requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function post($data) {
    // Configure caching settings.
    $build_nocache = new CacheableMetadata();
    $build_nocache->setCacheMaxAge(0);
    \Drupal::service('page_cache_kill_switch')->trigger();

    $name = urldecode($this->request->get('SS-UserName'));
    $pass = urldecode($this->request->get('SS-Password'));
    $this->checkAuth($name, $pass);

    $action = urldecode($this->request->get('action'));
    if ($action == 'shipnotify') {

      \Drupal::logger('shipstation_post')->notice($this->request->getUri());

      // Load Order.
      $order = \Drupal\commerce_order\Entity\Order::load($data['OrderID']);

      // Get Shipment.
      /** @var $first_shipment \Drupal\commerce_shipping\Entity\Shipment */
      if (!($first_shipment = reset($order->get('shipments')->referencedEntities()))) {
        return;
      }

      // Put tracking # on shipment.
      if (!empty($data['TrackingNumber'])) {
        $first_shipment->setTrackingCode($data['TrackingNumber']);
        $first_shipment->save();
      }

      // Move Order to completed.
      // Validation -> Completed.
      $transition = $order->getState()->getWorkflow()->getTransition('validate');
      $order->getState()->applyTransition($transition);
      $order->save();
      $transition = $order->getState()->getWorkflow()->getTransition('fulfill');
      $order->getState()->applyTransition($transition);
      $order->save();
      $order->unlock();
      return (new ResourceResponse(('Success, 200')));
    }
    return (new ResourceResponse('Missing required \'action\' parameter.', 402))->addCacheableDependency($build_nocache);
  }

  /**
   * Responds to GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get() {

    // Configure caching settings.
    $build_nocache = new CacheableMetadata();
    $build_nocache->setCacheMaxAge(0);
    \Drupal::service('page_cache_kill_switch')->trigger();

    $name = urldecode($this->request->get('SS-UserName'));
    $pass = urldecode($this->request->get('SS-Password'));
    $this->checkAuth($name, $pass);

    $action = urldecode($this->request->get('action'));

    if ($action == 'export') {
      \Drupal::logger('shipstation_get')->notice($this->request->getUri());
      $start_date = urldecode($this->request->get('start_date'));
      $end_date = urldecode($this->request->get('end_date'));

      if (empty($start_date) || empty($end_date)) {
        // Error.
        return (new ResourceResponse('start_date and end_date are required.', 402))->addCacheableDependency($build_nocache);
      }

      // Check dates for sanity.
      $start = new DateTime($start_date, new DateTimeZone(date_default_timezone_get()));
      $end = new DateTime($end_date, new DateTimeZone(date_default_timezone_get()));

      if (!($start_stamp = $start->getTimestamp()) || !($end_stamp = $end->getTimestamp())) {
        // Error.
        return (new ResourceResponse('start_date or end_date are not valid.', 402))->addCacheableDependency($build_nocache);

      }
      if ($end_stamp < $start_stamp) {
        // Error.
        return (new ResourceResponse('start_date must precede end_date.', 402))->addCacheableDependency($build_nocache);

      }

      $page = urldecode($this->request->get('page')) - 1;

      $data = new ShipstationData($start_stamp, $end_stamp, $page, 50);
      return (new ResourceResponse($data, 200))->addCacheableDependency($data);
    }
    else {
      // Error.
      return (new ResourceResponse('Missing required \'action\' parameter.', 402))->addCacheableDependency($build_nocache);
    }
  }

  /**
   * Throws exceptions if not authorized.
   * @param $name
   * @param $pass
   */
  private function checkAuth($name, $pass) {
    // Check permissions.
    if (empty($name) || empty($pass)) {
      // Error.
      throw new AccessDeniedHttpException(t('No user name and password supplied.'), null, 403);
    }
    // Get User.
    if (!empty($user = user_load_by_name($name))) {
      // Check if passwords match.
      if (!$this->passwordHasher->check($pass, $user->getPassword())) {
        // Error.
        throw new AccessDeniedHttpException(t('Username or password is incorrect.'), null, 403);
      }
      // Check permission.
      if (!$user->hasPermission('use shipstation api')) {
        // Error.
        throw new AccessDeniedHttpException(t('User cannot access shipstation api.'), null, 403);
      }
    }
    else {
      // Error.
      throw new AccessDeniedHttpException(t('User could not be found with name :name', [':name', $name]), null, 402);
    }
  }
}
