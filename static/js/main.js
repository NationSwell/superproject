$(function() {
    // expand/collapse header search field
    $("[for='search']").on("click", function() {
        $('#search').toggleClass('open');
    });

    // init slideshows
    $(".carousel").each(function(){
        var $this = $(this),
            $carousel = $this.find(".carousel__items");

        var isPhotoStory = $this.hasClass('carousel--photo');

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
                duration: 300
            },
            auto: {
                play: false
            },
            prev: {
                button: $this.find('.carousel__control--prev'),
                onBefore:
                    function() {
                        var pos = $carousel.triggerHandler("currentPosition");
                        alert(pos);
                        $carousel.children().removeClass('active');
                        $carousel.children(':nth-child('+ pos +')').addClass('active');
                    }
            },
            next: {
                button: $this.find('.carousel__control--next')
            }
        });
    });
});