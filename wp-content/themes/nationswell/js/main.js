(function ($) {
    $(function () {
        // expand/collapse header search field
        $("[for='search']").on("click", function () {
            $('#search').toggleClass('open');
        });

        // init slideshows
        $(".carousel").each(function () {
            var $this = $(this),
                $carousel = $this.find(".carousel__items");

            var isPhotoStory = $this.hasClass('carousel--photo');

            function highlight(items) {
                if(isPhotoStory) {
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
                responsive: isPhotoStory ? false : true,
                width: '100%',
                transition: true,
                items: {
                    visible: isPhotoStory ? 3 : 1,
                    start: isPhotoStory ? -1 : 1
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
    });
})(jQuery);