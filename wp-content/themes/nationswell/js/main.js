(function ($) {
    $(function () {
    // universal code
        
        // share popup window
        $('.btn--facebook, .btn--twitter').click(function (event) {
            var width = 575,
                height = 400,
                left = ($(window).width() - width) / 2,
                top = ($(window).height() - height) / 2,
                url = this.href,
                opts = 'status=1' +
                    ',width=' + width +
                    ',height=' + height +
                    ',top=' + top +
                    ',left=' + left;
            window.open(url, 'twitter', opts);
            return false;
        });

        // pageload modals
        $.each($("[data-modal-pageload='true']"), function(index, value){
            if(!$.cookie($(this).data("modal")))  {
                $(this).addClass('is-visible');
                $('body').addClass('is-locked');
            }
        });

        // resizing take action modals
        var fitTakeAction= function(modal) {
            var windowHeight = $(window).height(),
                currModalHeight = modal.outerHeight(),
                $taContent = modal.find('.take-action__inner');

            if ((windowHeight - currModalHeight) < (.2 * windowHeight)) {
                $taContent.css('height', .44 * windowHeight);
            }
        };

        // opening modals via button press
        $("[data-modal-target]").on("click", function(e) {
            var modalType = $(this).attr('data-modal-target'),
                $modal = $('.modal--' + modalType),
                $modalContent = $modal.find('.modal__content');

            if($modal.length) {
                if(modalType === 'take-action') {
                    var taContent = $('.story__take-action').html();
                    $modalContent.empty().append(taContent);

                    fitTakeAction($modal);

                    $(window).on('resize.resizeModal', function() {
                        fitTakeAction($modal);
                    });
                }

                $modal.addClass('is-visible');
                $('body').addClass('is-locked');
            }

            e.preventDefault();
        });

        // disabling modals
        $("[data-modal]").on("disable", function(event) {
            event.stopPropagation();

            $.cookie($(this).data("modal"), 'disabled', { expires: 5, path: '/' });
        });

        // closing modals
        var $modalClose = $(".modal-overlay, [data-modal-action='close']");
        $modalClose.on('click', function() {
            $('.modal').removeClass('is-visible');
            $('body').removeClass('is-locked');

            $(window).off('.resizeModal');

            if($(this).data('modal-disable')){
                $(this).trigger("disable");
            }
        });

        // clearing textarea placeholder text
        $('body').on('focus.textareaClear', 'textarea', function() {
            $(this).empty().unbind('.textareaClear');
        });

        // flyout box
        $('.story__container').waypoint(function (direction) {
            $('#flyout').toggleClass('is-visible', direction === "down");
        }, {
            offset: function () {
                return $.waypoints('viewportHeight') - $(this).height() + 200;
            }
        });

        $("[data-flyout-action='close']").on('click', function(){
            $(this).closest('#flyout').remove();
        });

        // expand/collapse header search field
        $('[for*="search"]').on('click', function() {
            var input = $(this).attr('for');
            $('#' + input).toggleClass('is-open');
        });

        // take action submission
        $('body').on('click.taSubmit', '.take-action__submit', function(e) {
            var $taAction = $('.take-action__action'),
                $taThankYou = $('.take-action__thank-you');

            $taAction.toggleClass('is-hidden');

            window.setTimeout(function() {
                $taAction.css('display', 'none');

                $taThankYou.css('display', 'block');
                $taThankYou.toggleClass('is-hidden');
            }, 300);

            $(window).off('.taSubmit');

            e.preventDefault();
        });

    // responsive code

        // mobile code
        enquire.register("screen and (max-width: 959px)", {
            // OPTIONAL
            // If supplied, triggered when a media query matches.
            match : function() {
                // toggle more stories panel
                $(".toggle-collapse").on("click.toggle-collapse", function(e) {
                    var $this = $(this),
                        target = $this.data("mobile-target"),
                        $target = $(target);

                    $this.toggleClass('is-toggled');
                    $target.toggleClass('panel--is-open');

                    e.preventDefault();
                });

                // slideshows
                $(".mobile-carousel").each(function () {
                    var $this = $(this),
                        $carousel = $this.find(".carousel__items"),
                        $externalContainer = $this.find('.mobile-carousel__external-container'),
                        $externalCaption = $externalContainer.find('.carousel-item__title'),
                        $externalIndicator = $externalContainer.find('.indicator');

                    if (!$carousel.length) {
                        $this.wrapInner('<ul class="carousel__items" />');
                        $carousel = $this.find(".carousel__items");
                    }

                    var isPeek = $this.hasClass('mobile-carousel--peek'),
                        isHero = $this.hasClass('mobile-carousel--hero'),
                        isSeries = $this.hasClass('carousel--series');

                    if (isHero) {
                        $this.append('<div class="carousel__pagination z3" />');
                    }

                    function unhighlight(items) {
                        items.removeClass('active');

                        if(isPeek) {
                            // fade out external content
                            $externalContainer.addClass('transitioning');
                        }

                        return items;
                    }

                    function highlight(items) {
                        // external slide titles
                        if(isPeek) {
                            var $activeSlide = items.filter(":eq(1)"),
                                $activeCaption = $activeSlide.find('.carousel-item__title > span').text(),
                                $activeIndicator = $activeSlide.find('.indicator').detach().removeClass('hide_mobile'),
                                $externalContainerLink = $externalContainer.find('.link-wrapper'),
                                activeHref = $activeSlide.find('.link-wrapper').attr('href');

                            $externalCaption.html($activeCaption);

                            if($externalIndicator && $activeIndicator) {
                                $externalIndicator.replaceWith($activeIndicator);
                            }

                            if($externalContainerLink.length) {
                                $externalContainerLink.attr('href', activeHref);
                            }

                            // fade in updated external content
                            $externalContainer.removeClass('transitioning');

                            $activeSlide.addClass('active');
                        } else {
                            items.addClass('active');
                        }

                        return items;
                    }
                    
                    // init slideshows
                    $carousel.carouFredSel({
                        responsive: isHero ? true : false,
                        width: '100%',
                        transition: true,
                        items: {
                            visible: isPeek ? 3 : 1,
                            start: isPeek ? -1 : 1
                        },
                        scroll: {
                            items: 1,
                            duration: 300,
                            onBefore: function (data) {
                                unhighlight(data.items.old);
                            },
                            onAfter: function (data) {
                                highlight(data.items.visible);
                            }
                        },
                        auto: {
                            play: false,
                            timeoutDuration: 8000
                        },
                        swipe: {
                            onTouch: true
                        },
                        pagination: {
                            container: $this.find('.carousel__pagination'),
                            deviation: isPeek ? 1 : 0
                        }
                    });
                });
            }

        // desktop code
        }).register("screen and (min-device-width:1024px)", {
            // If supplied, triggered when a media query matches.
            match : function() {
                // toggle more stories panel
                $(".toggle-collapse").on("click.toggle-collapse", function(e) {
                    var $this = $(this),
                        target = $this.data("desktop-target"),
                        $target = $(target);

                    $this.toggleClass('is-toggled');
                    $target.toggleClass('panel--is-open');

                    e.preventDefault();
                });

                // slideshows
                $(".carousel").each(function () {
                    var $this = $(this),
                        $carousel = $this.find(".carousel__items");

                    var isPeek = $this.hasClass('carousel--peek'),
                        isSeries = $this.hasClass('carousel--series');

                    function highlight(items) {
                        if(isPeek) {
                            items.filter(":eq(1)").addClass('active');
                        } else {
                            items.addClass('active');
                        }

                        return items;
                    }

                    function unhighlight(items) {
                        items.removeClass('active');
                        return items;
                    }

                    // init slideshows
                    $carousel.carouFredSel({
                        responsive: isSeries ? true : false,
                        width: '100%',
                        transition: true,
                        items: {
                            visible: isPeek ? 3 : 1,
                            start: isPeek ? -1 : 1
                        },
                        scroll: {
                            items: 1,
                            duration: 300,
                            onBefore: function (data) {
                                unhighlight(data.items.old);
                            },
                            onAfter: function (data) {
                                highlight(data.items.visible);
                            }
                        },
                        auto: {
                            play: false
                        },
                        prev: {
                            button: $this.find('.carousel__control--prev'),
                            key: "left"
                        },
                        next: {
                            button: $this.find('.carousel__control--next'),
                            key: "right"
                        }
                    });
                });

                // sticky sharebar
                var $stickyBar = $('.story__sticky-container'),
                    $stickySocial = $('.sticky-social'),
                    $stickyTakeAction = $('.sticky-take-action');

                $stickyBar.waypoint('sticky', {
                    stuckClass: 'stuck',
                    offset: 60
                });

                // bottoming out sharebar at end of article
                /*var $mainContainer = $('.story__container');
                $mainContainer.waypoint(function(direction){
                    $(this).toggleClass('bottomed', direction === 'down');
                }, {
                    offset:function() {
                        return  $stickyBar.outerHeight() - $(this).outerHeight() + 60;
                    }
                });*/

                // sliding social buttons
                var $storySocial = $('.story__social');
                $storySocial.waypoint(function(direction){
                    $storySocial.toggleClass('is-visible', direction === 'down');
                    $stickySocial.toggleClass('is-hidden', direction === 'down');
                }, {
                    offset:function() {
                        var offsetHeight;

                        if(!$stickyTakeAction.length) {
                            offsetHeight = .8 * $stickyBar.outerHeight();
                        } else {
                            offsetHeight = $stickyBar.outerHeight() - (1.2 * $stickySocial.outerHeight());
                        }

                        return offsetHeight;
                    }
                });

                // sliding take action module
                var $storyTakeAction = $('.story__take-action');
                if ($storyTakeAction.length) {
                    $storyTakeAction.waypoint(function(direction) {
                        $storyTakeAction.toggleClass('is-visible', direction === 'down');
                        $stickyTakeAction.toggleClass('is-hidden', direction === 'down');
                    }, {
                        offset: function() {
                            var offsetHeight = .8 * $stickyBar.outerHeight();
                            return offsetHeight;
                        }
                    });
                }
            }
        });
    });
})(jQuery);