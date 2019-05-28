(function ($, Drupal) {

    "use strict";

    /**
     * Animate transition to anchor.
     */
    Drupal.behaviors.btwBaseAnimateAnchors = {
        attach: function(context) {
            $('.smooth-scroll', context).click(function() {
                var id = $(this).attr('scrollto-id');
                if (typeof id == 'undefined') {
                    alert ('no scrollto-id defined');
                }
                var offset = $(this).attr('scrollto-offset');
                if (typeof offset == 'undefined') {
                    offset = "0";
                }
                var speed = $(this).attr('scrollto-speed');
                if (typeof speed == 'undefined') {
                    speed = "1500";
                }
                if (!(typeof id == 'undefined')) {
                    $('html, body').animate(
                        {
                            scrollTop: $('#' + id).offset().top + parseInt(offset)
                        }, parseInt(speed)
                    );
                }
                return false;
            });
        }
    };

    /**
     * Mobile slide-down functionality, kill top level.
     */
    Drupal.behaviors.btwBaseKillProdCatLink = {
        attach: function (context) {
            $('.nav-kill', context).click(function(e) {
                e.preventDefault();
                return false;
            });
        }
    };

    /**
     * Slide down js.
     */
    Drupal.behaviors.btwBaseMobileSlidedown = {
        attach: function (context) {
            $('.slide-down-menu .expanded a.main-nav', context).click(function(e) {
                var targ = $(this).next('ul').first();
                targ.slideToggle();
                return false;
            });
            //toggle mobile nav classes that show/hide menu links
            $('#mobile-nav-open-btn', context).bind('click', function(e) {
                $('html').toggleClass('js-nav');
                e.preventDefault();
                return false;
            });
            $('#mobile-nav-close-btn,#mobile-fade', context).bind('click', function(e) {
                $('html').removeClass('js-nav');
                e.preventDefault();
                return false;
            });
        }
    };


})(jQuery, Drupal);
