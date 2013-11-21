(function ($) {
    $(function () {

        // Modal
        $.each($("[data-modal-pageload='true']"), function(index, value){

            if(!$.cookie($(this).data("modal")))  {

                $(this).addClass('modal--is-visible');
                $('body').addClass('locked');

            }

        });

        $("[data-modal-target]").on("click", function(e) {
            var modalType = $(this).attr('data-modal'),
                $modal = $('.modal--' + modalType),
                $modalContent = $modal.find('.modal__content');

            if(modalType === 'take-action') {
                var taContent = $('.story__take-action').html();
                $modalContent.empty().append(taContent);
            }

            $modal.addClass('modal--is-visible');
            $('body').addClass('locked');

            e.preventDefault();
        });

        $("[data-modal]").on("disable", function(event){

            event.stopPropagation();

            $.cookie($(this).data("modal"), 'disabled', { expires: 5, path: '/' });

        });

        var $modalClose = $(".modal-overlay, [data-modal-action='close']");

        $modalClose.on('click', function() {
            $('.modal').removeClass('modal--is-visible');
            $('body').removeClass('locked');

            if($(this).data('modal-disable')){
                $(this).trigger("disable");
            }
        });




        // flyout box
        $('.story__container').waypoint(function (direction) {
            $('#flyout').toggleClass('hiding', direction === "up");
        }, {
            offset: function () {
                return $.waypoints('viewportHeight') - $(this).height() + 200;
            }
        });

        // expand/collapse header search field
        $("[for='search']").on("click", function() {
            $('#search').toggleClass('open');
        });

        enquire.register("screen and (max-width: 959px)", {
            // OPTIONAL
            // If supplied, triggered when a media query matches.
            match : function() {
                // toggle more stories panel
                $(".toggle-collapse").on("click.toggle-collapse", function(e) {
                    var $this = $(this),
                        target = $this.data("mobile-target"),
                        $target = $(target);

                    $this.toggleClass('toggled');
                    $target.toggleClass('panel-open');

                    e.preventDefault();
                });

                // init slideshows
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
                            // TEMP: styling
                            play: false,
                            timeoutDuration: 8000
                        },
                        swipe: {
                            onTouch: true,
                            // TEMP: styling
                            onMouse: true
                        },
                        pagination: {
                            container: $this.find('.carousel__pagination'),
                            deviation: isPeek ? 1 : -1
                        }
                    });
                });
            }
        }).register("screen and (min-width:1024px)", {
            // OPTIONAL
            // If supplied, triggered when a media query matches.
            match : function() {
                // toggle more stories panel
                $(".toggle-collapse").on("click.toggle-collapse", function(e) {
                    var $this = $(this),
                        target = $this.data("desktop-target"),
                        $target = $(target);

                    $this.toggleClass('toggled');
                    $target.toggleClass('panel-open');

                    e.preventDefault();
                });

                // init slideshows
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
                            button: $this.find('.carousel__control--prev')
                        },
                        next: {
                            button: $this.find('.carousel__control--next')
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

                /*var $mainContainer = $('.story__container');
                $mainContainer.waypoint(function(direction){
                    $(this).toggleClass('bottomed', direction === 'down');
                }, {
                    offset:function() {
                        return  $stickyBar.outerHeight() - $(this).outerHeight() + 60;
                    }
                });*/

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