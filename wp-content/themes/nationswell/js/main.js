(function ($) {
    $(function () {
        // expand/collapse header search field
        $("[for='search']").on("click", function () {
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

                    if($target.length) {
                        $this.toggleClass('toggled');
                        $target.toggleClass('open');
                    }

                    e.preventDefault();
                });

                // init slideshows
                $(".mobile-carousel").each(function () {
                    var $this = $(this),
                        $carousel = $this.find(".carousel__items");

                    if (!$carousel.length) {
                        $this.wrapInner('<ul class="carousel__items" />');
                        $carousel = $this.find(".carousel__items");
                    }

                    var isPeek = $this.hasClass('mobile-carousel--peek'),
                        isHero = $this.hasClass('mobile-carousel--hero');

                    if (isHero) {
                        $this.append('<div class="carousel__pagination z3" />');
                    }

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
            },

            // OPTIONAL
            // If supplied, triggered when the media query transitions
            // *from a matched state to an unmatched state*.
            unmatch : function() {},

            // OPTIONAL
            // If supplied, triggered once, when the handler is registered.
            setup : function() {},

            // OPTIONAL, defaults to false
            // If set to true, defers execution of the setup function
            // until the first time the media query is matched
            deferSetup : true,

            // OPTIONAL
            // If supplied, triggered when handler is unregistered.
            // Place cleanup code here
            destroy : function() {}

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
                    $target.toggleClass('open');

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

                var $sharebar = $('.story__sticky-container');

                $sharebar.waypoint('sticky', {
                    wrapper: '<div class="story__sticky" />',
                    stuckClass: 'stuck',
                    offset: 50
                });
            },

            // OPTIONAL
            // If supplied, triggered when the media query transitions
            // *from a matched state to an unmatched state*.
            unmatch : function() {
            },

            // OPTIONAL
            // If supplied, triggered once, when the handler is registered.
            setup : function() {},

            // OPTIONAL, defaults to false
            // If set to true, defers execution of the setup function
            // until the first time the media query is matched
            deferSetup : true,

            // OPTIONAL
            // If supplied, triggered when handler is unregistered.
            // Place cleanup code here
            destroy : function() {}

        });
    });
})(jQuery);