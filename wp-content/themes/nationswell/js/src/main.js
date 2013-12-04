(function ($) {
    $(function () {
        var $body = $('body');

        // sticky nav
        var $fullNavBar = $('.full-header');
        $fullNavBar.waypoint('sticky', { stuckClass: 'stuck' });

        // Ajaxify Subscribe Forms
        $('.mc-form').ajaxChimp({
            callback: function (resp) {
                if (resp.result === 'success') {
                } else if (resp.result === 'error') {
                }

            }
        });

        audiojs.events.ready(function () {
            var as = audiojs.createAll();
        });

        // share popup window
        $('.btn--share').click(function (event) {
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
        $.each($("[data-modal-pageload='true']"), function (index, value) {
            if (!$.cookie($(this).data("modal"))) {

                var that = this;

                setTimeout(function () {
                    $(that).addClass('is-visible');
                    $body.addClass('is-locked');
                }, 1500);

            }
        });

        // resizing take action modals
        var fitTakeAction = function (modal) {
            var windowHeight = $(window).height(),
                currModalHeight = modal.outerHeight(),
                $taContent = modal.find('.take-action__inner');

            if ((windowHeight - currModalHeight) < (.2 * windowHeight)) {
                $taContent.css('height', .44 * windowHeight);
            }
        };

        // opening modals via button press
        $("[data-modal-target]").on("click", function (e) {
            var modalType = $(this).attr('data-modal-target'),
                $modal = $('.modal--' + modalType),
                $modalContent = $modal.find('.modal__content');

            if ($modal.length) {
                if (modalType === 'take-action') {
                    var taContent = $('.story__take-action').html();
                    $modalContent.empty().append(taContent);

                    fitTakeAction($modal);

                    $(window).on('resize.resizeModal', function () {
                        fitTakeAction($modal);
                    });
                }

                $modal.addClass('is-visible');
                $body.addClass('is-locked');
            }

            e.preventDefault();
        });

        // disabling modals
        $("[data-modal]").on("disable", function (event, expireDuration) {
            event.stopPropagation();

            $.cookie($(this).data("modal"), 'disabled', { expires: expireDuration, path: '/' });
        });

        // closing modals
        var $modalClose = $(".modal-overlay, [data-modal-action='close']");
        $modalClose.on('click', function () {
            $('.modal').removeClass('is-visible');
            $body.removeClass('is-locked');

            $(window).off('.resizeModal');

            if ($(this).data('modal-disable')) {
                $("[data-modal]:visible").trigger("disable", [ $(this).data('modal-disable') ]);
            }
        });

        // clearing textarea placeholder text
        $body.on('focus.textareaClear', 'textarea', function () {
            $(this).empty().unbind('.textareaClear');
        });

        setTimeout(function () {
            $('#flyout').toggleClass('is-visible');
        }, 15000);


        $("[data-flyout-action='close']").on('click', function () {
            $(this).closest('#flyout').remove();
        });

        // expand/collapse header fields
        $('[for*="nav-"]').on('click', function (e) {
            var $this = $(this),
                input = $this.attr('for'),
                $field = $('#' + input),
                isOpen = $field.hasClass('is-open');

            $('[id*="nav-"]').removeClass('is-open');

            if ($this.attr('for') === 'nav-subscribe') {
                $this.removeClass('error valid');
            }

            if (!isOpen) {
                $field.addClass('is-open');
            } else {
                e.preventDefault();
            }
        });

        // responsive code

        // mobile code
        enquire.register("screen and (max-device-width: 767px)", {
            // OPTIONAL
            // If supplied, triggered when a media query matches.
            match: function () {
                // toggle more stories panel
                $(".toggle-collapse").on("click.toggle-collapse", function (e) {
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

                    // wrap homepage hero grid in caroufredsel container
                    if (!$carousel.length) {
                        $this.wrapInner('<ul class="carousel__items" />');
                        $carousel = $this.find(".carousel__items");
                    }

                    var isPeek = $this.hasClass('mobile-carousel--peek'),
                        isFullPeek = isPeek && $carousel.children().length > 3,
                        isSingle = $this.hasClass('mobile-carousel--single');

                    if (isSingle) {
                        $this.append('<div class="carousel__pagination z3" />');
                    }

                    $carousel.find('.carousel-item').first().addClass('active');

                    function unhighlight(items) {
                        items.removeClass('active');

                        if (isPeek) {
                            // fade out external content
                            $externalContainer.addClass('transitioning');
                        }

                        return items;
                    }

                    function highlight(items) {
                        // external slide titles
                        if (isPeek) {
                            var $activeSlide = isFullPeek ? items.filter(":eq(1)") : items.filter(":eq(0)"),
                                $activeCaption = $activeSlide.find('.carousel-item__title > span').text(),
                                $activeIndicator = $activeSlide.find('.indicator').detach().removeClass('hide_mobile'),
                                $externalContainerLink = $externalContainer.find('.link-wrapper'),
                                activeHref = $activeSlide.find('.link-wrapper').attr('href');

                            $externalCaption.html($activeCaption);

                            if ($externalIndicator && $activeIndicator) {
                                $externalIndicator.replaceWith($activeIndicator);
                            }

                            if ($externalContainerLink.length) {
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
                        responsive: isSingle ? true : false,
                        width: '100%',
                        transition: true,
                        items: {
                            visible: isFullPeek ? 3 : 1,
                            start: isFullPeek ? -1 : 0
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
                            timeoutDuration: 6000
                        },
                        swipe: {
                            onTouch: true
                        },
                        pagination: {
                            container: $this.find('.carousel__pagination'),
                            deviation: isFullPeek ? 1 : 0
                        }
                    });
                });
            }

            // desktop code
        }).register("screen and (min-device-width:768px)", {
                // If supplied, triggered when a media query matches.
                match: function () {
                    // toggle more stories panel
                    $(".toggle-collapse").on("click.toggle-collapse", function (e) {
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

                        var isPeek = $this.hasClass('carousel--peek') && $carousel.children().length > 3,
                            isSeries = $this.hasClass('carousel--series');

                        function highlight(items) {
                            if (isPeek) {
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
                        offset: 132
                    });

                    // sliding social buttons
                    var $storySocial = $('.story__social');
                    $storySocial.waypoint(function (direction) {
                        $storySocial.toggleClass('is-visible', direction === 'down');
                        $stickySocial.toggleClass('is-hidden', direction === 'down');
                    }, {
                        offset: function () {
                            var offsetHeight;

                            if (!$stickyTakeAction.length) {
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
                        $storyTakeAction.waypoint(function (direction) {
                            $storyTakeAction.toggleClass('is-visible', direction === 'down');
                            $stickyTakeAction.toggleClass('is-hidden', direction === 'down');
                        }, {
                            offset: function () {
                                var offsetHeight = .8 * $stickyBar.outerHeight();
                                return offsetHeight;
                            }
                        });
                    }
                }
            });

        // load more button
        $('#page-content').on('click', '.btn--load-more', function (e) {
            var $link = $(this),
                $container = $link.parent('.btn-container'),
                url = $link.attr('href') + '?ajax-more=true';

            $.get(url, function (html) {
                $container.replaceWith(html);
            });

            e.preventDefault();
        });

        // call to action
        function showThankYou() {
            var $taAction = $('.take-action__action'),
                $taThankYou = $('.take-action__thank-you');

            $taAction.toggleClass('is-hidden');

            window.setTimeout(function () {
                $taAction.css('display', 'none');

                $taThankYou.css('display', 'block');
                $taThankYou.toggleClass('is-hidden');
            }, 300);
        }

        // take action submission
        $body.on('click.taSubmit', '.take-action__submit', function (e) {
            showThankYou();

            $(window).off('.taSubmit');

            e.preventDefault();
        });


        $('#change-org-petition').submit(function (e) {
            var $form = $(this),
                url = '/wp-admin/admin-ajax.php?action=sign_petition&cta_id=' + $form.attr('data-cta-id');

            $.post(url, $form.serialize())
                .done(function () {
                    showThankYou();
                })
                .fail(function (data) {
                    console.log(data);
                });

            e.preventDefault();
        }).validate();

         function lookupReps(address, callback) {
            $.ajax({
                url: 'https://www.googleapis.com/civicinfo/us_v1/representatives/lookup?key=AIzaSyAffyAu22rVhDqArXZ7F8jjmCU_ZYKRINU',
                type: 'POST',
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify({ address: address }),
                dataType: 'json',
                success: function(data) {
                    var officialsById = {}, officials;

                    $.each(data.offices, function(i, office) {
                        if(office.level === 'federal' &&
                            (office.name.indexOf('House') !== -1 || office.name.indexOf('Senate') !== -1)) {

                            $.each(office.officialIds, function(i, id){
                                officialsById[id] = { office: office.name };
                            });
                        }
                    });

                    $.each(officialsById, function(id, official) {
                        official = $.extend(official, data.officials[id]);

                        official.party = official.party === 'Democratic' ? 'Democrat' : official.party;

                        $.each(official.channels, function(){
                            if(this.type === 'Twitter') {
                                official.twitter = this.id;
                                return false;
                            }
                        });
                    });

                    officials = $.map(officialsById, function(value) { return value; });

                    callback(officials);
                }
            });
        }

        $('#politician-lookup').submit(function(e){
            lookupReps($(this).find('[name=address]').val(), function(reps) {
                var $politicians = $('#tweet-a-politician');
                $politicians.empty();
                $.each(reps, function(){
                    $politicians.append(politicianTemplate(this));
                });

            });
            e.preventDefault();
        }).validate();


        function politicianTemplate(politician) {
            var $politician,

                html =
                '<div class="politician">';

            if(politician.photoUrl) {
                html += '   <img src="' + politician.photoUrl +'" alt="' + politician.name +'" />';
            }

            html +=
                '   <span class="name">' + politician.name +'</span>' +
                '   <span class="office">' + politician.party + ' - ' + politician.office +'</span>' +
                '   <span class="twitter">@' + politician.twitter +'</span>' +
                '   <button class="tweet">Tweet</button>' +
                '</div>';

            // Event handlers
            $politician = $(html);
            $politician.find('.tweet').click(function(){
                alert('Tweeting @' + politician.twitter);
            });

            return $politician;
        }


    });
})(jQuery);