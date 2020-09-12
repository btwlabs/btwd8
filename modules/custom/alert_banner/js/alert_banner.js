(function ($, Drupal, Cookies) {
  'use strict';

  Drupal.behaviors.alertBanner = {
    attach: function (context) {
      // If alert_banner cookie is availble set it to $banner_status otherwise set to 0;
      // https://github.com/js-cookie/js-cookie
      var bannerStatus = Cookies.get('alert_banner') ? Cookies.get('alert_banner') : 0;
      if (bannerStatus === 0) {
        $('.block-alert-banner', context).delay(1000).addClass('is-visible');
      }
      // Close Popup
      $('.alert-banner-popup button', context).click(function(event){
        event.preventDefault();
        $('.block-alert-banner', context).removeClass('is-visible');
        // If custom alert message is closed then set a cookie
        Cookies.set('alert_banner', '1', { expires: 0.25 });
      });

      // Close popup when clicking the esc keyboard button
      $(document).keyup(function(event){
        if(event.which==='27'){
          $('.block-alert-banner', context).removeClass('is-visible');
        }
      });
    }
  };

})(jQuery, Drupal, Cookies);
