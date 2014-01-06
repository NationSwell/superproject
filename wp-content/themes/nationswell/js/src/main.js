(function ($) {
    $(function () {

//        var viewPortScale = 1 / window.devicePixelRatio;
//        $('meta[name="viewport"]').attr('content', 'user-scalable=no, initial-scale='+viewPortScale+', width=device-width');

        // sticky nav
        var $fullHeader = $('.full-header');
        $fullHeader.waypoint('sticky', { stuckClass: 'stuck' });

        var $body = $('body');

        $('.hero-read-link').on('click', function(e){
            e.preventDefault();

            var top = $($(this).attr('href')).offset().top - $('#page-header').height();

            $body.animate({scrollTop: top }, '500');
        });

        // ajaxify Subscribe Forms
        $('.mc-form').each(function(){

            var $this = $(this),
                module = getModule($this);

            $this.ajaxChimp({
                callback: function (resp) {
                    if (resp.result === 'success') {
                        setTimeout(function(){
                            toggleThankYou();
                        }, 500);

                        events.trigger('newsletter-subscribed', [module]);

                    } else if (resp.result === 'error') {
                        events.trigger('newsletter-subscribe-fail', [module, resp]);
                    }

                }
            });

        });

        audiojs.events.ready(function () {
            var as = audiojs.createAll();
        });

        // share popup window
        $body.on('click', '.btn--share', function (event) {
            event.preventDefault();
            event.stopPropagation();

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
            window.open(url, '', opts);
        });

        // pageload modals
        $.each($("[data-modal-pageload='true']"), function (index, value) {
            if (!$.cookie($(this).data("modal"))) {

                var that = this;

                setTimeout(function () {
                    $(that).addClass('is-visible');
                    $body.addClass('is-locked');

                    events.trigger("modal-open", [$(that).data("modal")]);

                }, 1500);

            }
        });

        // resizing take action modals
        var fitTakeAction = function (modal) {
            var windowHeight = $(window).height(),
                currModalHeight = modal.outerHeight(),
                $taContent = modal.find('.take-action__inner');

            $taContent.css('height', .44 * windowHeight);
        };

        // opening modals via button press
        $("[data-modal-target]").on("click", function (e) {
            var modalType = $(this).attr('data-modal-target'),
                $modal = $('.modal--' + modalType),
                $modalContent = $modal.find('.modal__content');

            if ($modal.length) {
                if (modalType === 'take-action') {
                    var taContent = $('.story__take-action').contents();
                    $modalContent.empty().append(taContent);

                    fitTakeAction($modal);

                    $(window).on('resize.resizeModal', function () {
                        fitTakeAction($modal);
                    });
                }
                $modal.addClass('is-visible');
                /*$body.addClass('is-locked');*/
                events.trigger("modal-open", [$modal.data("modal")]);
            }

            e.preventDefault();
            return false;
        });

        // disabling modals
        $("[data-modal]").on("disable", function (event, expireDuration) {
            event.stopPropagation();

            events.trigger("modal-disable", [$(this).data("modal"), expireDuration]);

            $.cookie($(this).data("modal"), 'disabled', { expires: expireDuration, path: '/' });
        });

        // closing modals
        var $modalClose = $(".modal-overlay, [data-modal-action='close']");
        $modalClose.on('click', function () {
            var $modal = $('.modal.is-visible');

            $modal.removeClass('is-visible');
            /*$body.removeClass('is-locked');*/

            if ($modal.hasClass('modal--take-action')) {
                $modal.find('.take-action__inner').css('height', '');
                $('.story__take-action').append($modal.find('.modal__content').contents());
            }

            $(window).off('.resizeModal');

            if ($(this).data('modal-disable')) {
                $modal.trigger("disable", [ $(this).data('modal-disable') ]);
            }

            events.trigger("modal-close", [$modal.data("modal")]);
        });

        // clearing textarea placeholder text
        $body.on('focus.textareaClear', 'textarea', function () {
            $(this).empty().unbind('.textareaClear');
        });

        // Initialize Twitter API
        window.twttr = (function (d,s,id) {
            var t, js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return; js=d.createElement(s); js.id=id;
            js.src="https://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs);
            return window.twttr || (t = { _e: [], ready: function(f){ t._e.push(f) } });
        }(document, "script", "twitter-wjs"));

        // Subscribe to Twitter Events
        twttr.ready(function (twttr) {
            var event_names = {
                "click": "",
                "tweet": "",
                "retweet": "source_tweet_id",
                "follow": "screen_name",
                "favorite": "tweet_id"
            };

            for (var event_name in event_names) {
                if (event_names.hasOwnProperty(event_name)) {
                    twttr.events.bind(event_name, function (intent_event) {
                        if (intent_event) {
                            var label = intent_event.type === "click" ? intent_event.region : (intent_event.data) ? intent_event.data[event_names[intent_event.type]] : "";
                            events.trigger('twitter', [getModule($(intent_event.target)), intent_event.type, label]);
                        }
                    });
                }
            }
        });

        // Subscribe to Facebook Like Event
        // Track Like Event
        // Track UnLike Event
        // Track Comment: Create
        // Disable the Flyout
        window.fbAsyncInit = function() {
            FB.Event.subscribe('edge.create',
                function(href, widget) {
                    events.trigger('facebook-like', [$(widget).data("module"), href]);

                    $.cookie('flyout', 'disabled', { expires: 5, path: '/' });
                }
            );

            FB.Event.subscribe('edge.remove',
                function(href, widget){
                    events.trigger('facebook-unlike', [$(widget).data("module"), href]);
            });

            FB.Event.subscribe('comment.create',
                function(href, commentID){
                    events.trigger('facebook-comment', [href, commentID]);
            });
        };


        if (!$.cookie('flyout')) {

            setTimeout(function () {
                $('#flyout').toggleClass('is-visible');
                events.trigger('flyout-open',[getModule($('#flyout'))]);
            }, 0);

        }

        $("[data-flyout-action='close']").on('click', function () {
            var $flyout = $(this).closest('#flyout'),
                expireDuration = $(this).data('flyout-disable');
            $flyout.hide();

            $.cookie('flyout', 'disabled', { expires: expireDuration, path: '/' });
        });

        // expand/collapse header fields
        $('[for*="nav-"]').on('click', function (e) {
            var $this = $(this),
                input = $this.attr('for'),
                $field = $('#' + input),
                isOpen = $field.hasClass('is-open');

            $('[id*="nav-"]').removeClass('is-open');

            if (input === 'nav-subscribe') {
                $this.removeClass('error valid');
            }

            if (!isOpen) {
                events.trigger(input + '-open', getModule($this));
                $field.addClass('is-open');
            } else {
                e.preventDefault();
            }
        });

        var $informationContainer = $('.hero-information'),
            $slideCaption = $informationContainer ? $informationContainer.find('.hero-information__caption') : false,
            $slideCredit = $informationContainer ? $informationContainer.find('.hero-information__credit') : false;

        $informationContainer.on('click', function() {
            $(this).toggleClass('is-open');
        });

        // responsive code

        // mobile code
        var mobile = {
            match: function () {
                var $fullHeader = $('.full-header'),
                    $stickyWrapper = $('.sticky-wrapper');

                setTimeout(function() {
                    var fullHeaderHeight = $fullHeader.outerHeight();
                    $stickyWrapper.outerHeight(fullHeaderHeight);
                    $stickyWrapper.css('height', fullHeaderHeight + 'px');
                }, 300);

                // toggle more stories panel
                $(".toggle-collapse").on("click.mobile-toggle-collapse", function (e) {
                    var $this = $(this),
                        target = $this.data("mobile-target"),
                        $target = $(target);

                    $this.toggleClass('is-toggled');
                    $target.toggleClass('panel--is-open');

                    if($this.hasClass('is-toggled')){
                        events.trigger('nav-more-stories-open',[getModule($this)]);
                    }

                    e.preventDefault();
                });

                $(".more-stories-drawer").swipe( {
                    swipeRight: function() {
                        if($body.hasClass('panel--is-open')) {
                            $body.removeClass('panel--is-open');
                            $('.more-stories-toggle').removeClass('is-toggled');
                        }
                    }
                });

                var $storySocial = $('.story__social').detach(),
                    $storyContent = $('#story');

                if ($storyContent) {
                    $storySocial.clone().prependTo($storyContent);
                    $storySocial.clone().appendTo($storyContent);
                }

                /*if ($informationContainer) {
                 var $hero = $('.hero--story'),
                 infoHeight = $informationContainer.outerHeight() + 30;

                 if($hero && !$hero.hasClass('hero--carousel')) {
                 $hero.css({'margin-bottom': infoHeight});
                 }
                 }*/

                // slideshows
                $(".mobile-carousel").each(function () {
                    var $this = $(this),
                        $carousel = $this.find(".carousel__items"),
                        $externalContainer = $this.find('.mobile-carousel__external-container'),
                        $externalCaption = $externalContainer.find('.carousel-item__title');

                    $this.imagesLoaded( function() {});

                    // wrap homepage hero grid in caroufredsel container
                    if (!$carousel.length) {
                        $this.wrapInner('<ul class="carousel__items" />');
                        $carousel = $this.find(".carousel__items");
                    }

                    var isPeek = $this.hasClass('mobile-carousel--peek'),
                        isFullPeek = isPeek && $carousel.children().length > 3,
                        isSingle = $this.hasClass('mobile-carousel--single'),
                        isStory = $this.closest('.hero--story').length;

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
                                $activeIndicator = $activeSlide.find('.indicator--title').clone().removeClass('hide_mobile'),
                                $externalContainerLink = $externalContainer.find('.link-wrapper'),
                                $externalIndicator = $externalContainer.find('.indicator--title'),
                                activeHref = $activeSlide.find('.link-wrapper').attr('href');

                            $externalCaption.html($activeCaption);

                            if ($externalIndicator && $activeIndicator) {
                                $externalIndicator.replaceWith($activeIndicator).show();
                            } else {
                                $externalIndicator.empty();
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

                        if (isStory) {
                            $activeSlide = items.filter(":eq(0)");

                            var activeSlideCaption = $activeSlide.data('item-caption'),
                                activeSlideCredit = $activeSlide.data('item-credit');

                            activeSlideCaption ? $slideCaption.html(activeSlideCaption) : $slideCaption.empty();
                            activeSlideCredit ? $slideCredit.html(activeSlideCredit) : $slideCredit.empty();
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
                            play: isSingle && !isStory ? true : false,
                            timeoutDuration: 6000
                        },
                        swipe: {
                            onTouch: true,
                            onMouse: true
                        },
                        pagination: {
                            container: $this.find('.carousel__pagination'),
                            deviation: isFullPeek ? 1 : 0
                        }
                    });
                });
            },

            unmatch: function() {
                $(".toggle-collapse").off('.mobile-toggle-collapse').removeClass('is-toggled');
                $('.panel--is-open').removeClass('panel--is-open');

                var $storyContent = $('#story');
                if ($storyContent) {
                    // removing programmatically added top social button bar
                    $('.story__social:first-child').remove();

                    var $storySocial = $(".story__social").detach();
                    $('.fb-comments').before($storySocial);

                    $('.sticky-social').removeClass('is-hidden');
                    $('story__social').removeClass('is-visible');

                    $('.is-long, .is-open').removeClass('is-long is-open');
                }

                $('.mobile-carousel').find('.carousel__items').trigger('destroy', true);
            }

        };

        var desktop = {
            match: function () {
                var $fullHeader = $('.full-header'),
                    $stickyWrapper = $('.sticky-wrapper');

                setTimeout(function() {
                    var fullHeaderHeight = $fullHeader.outerHeight();
                    $stickyWrapper.outerHeight(fullHeaderHeight);
                }, 300);

                // toggle more stories panel
                $(".toggle-collapse").on("click.desktop-toggle-collapse", function (e) {
                    var $this = $(this),
                        target = $this.data("desktop-target"),
                        $target = $(target);

                    $this.toggleClass('is-toggled');
                    $target.toggleClass('panel--is-open');

                    if($this.hasClass('is-toggled')){
                        events.trigger('nav-more-stories-open',[getModule($this)]);
                    }

                    e.preventDefault();
                });

                $("#more-stories").swipe( {
                    swipeUp: function(event, direction, distance, duration, fingerCount) {
                        var $moreStories = $('#more-stories');

                        if($moreStories.hasClass('panel--is-open')) {
                            $moreStories.removeClass('panel--is-open');
                            $('.more-stories-toggle').removeClass('is-toggled');
                        }
                    }
                });

                var isTallInfo = function() {
                    var $informationContainer = $('.hero-information'),
                        $slideCaption = $informationContainer.find('.hero-information__caption'),
                        $slideCredit = $informationContainer.find('.hero-information__credit');

                        $informationContainer.removeClass('is-long is-open');

                        if ($slideCaption.outerHeight() > $informationContainer.outerHeight() || $slideCredit.outerHeight() > $informationContainer.height() ) {
                            $informationContainer.addClass('is-long');
                        }
                };

                if($informationContainer) {
                    isTallInfo();
                }

                // slideshows
                $(".carousel").each(function () {
                    var $this = $(this),
                        $carousel = $this.find(".carousel__items");

                    var isPeek = $this.hasClass('carousel--peek') && $carousel.children().length > 3,
                        isSeries = $this.hasClass('carousel--series'),
                        isStory = $this.closest('.hero--story').length;

                    $this.imagesLoaded( function() {
                        $this.find('img').addClass('is-visible');
                    });


                    function highlight(items) {
                        if (isPeek) {
                            var $activeSlide = items.filter(":eq(1)").addClass('active');

                            if(isStory) {
                                var activeSlideCaption = $activeSlide.data('item-caption'),
                                    activeSlideCredit = $activeSlide.data('item-credit');

                                activeSlideCaption ? $slideCaption.html(activeSlideCaption): $slideCaption.empty();
                                activeSlideCredit ? $slideCredit.html(activeSlideCredit): $slideCredit.empty();

                                isTallInfo();
                            }
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
                        },
                        swipe: {
                            onTouch: true,
                            onMouse: true
                        }
                    });
                });

                // sticky sharebar
                var $stickyBar = $('.story__sticky-container'),
                    $stickySocial = $('.sticky-social'),
                    $stickyTakeAction = $('.sticky-take-action');

                if(!$stickyBar.parent('.sticky-wrapper').length) {
                    $stickyBar.waypoint('sticky', {
                        stuckClass: 'stuck',
                        offset: 132
                    });
                }

                // sliding social buttons
                var $storySocial = $('.story__social');
                $storySocial.waypoint(function (direction) {
                    var down = direction === 'down';
                    $storySocial.toggleClass('is-visible', down).toggleClass('is-hidden', down);
                    $stickySocial.toggleClass('is-hidden', down).toggleClass('is-visible', down);
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
                        var down = direction === 'down';
                        $storyTakeAction.toggleClass('is-visible', down).toggleClass('is-hidden', down);
                        $stickyTakeAction.toggleClass('is-hidden', down).toggleClass('is-visible', down);
                    }, {
                        offset: function () {
                            return  .8 * $stickyBar.outerHeight();
                        }
                    });
                }
            },

            unmatch: function() {
                $(".toggle-collapse").off('.desktop-toggle-collapse').removeClass('is-toggled');
                $('.panel--is-open').removeClass('panel--is-open');

                $('.carousel').find('.carousel__items').trigger('destroy', true);

                var $stickyBar = $('.story__sticky-container'),
                    $storySocial = $('.story__social'),
                    $storyTakeAction = $('.story__take-action');

                /*$stickyBar.waypoint('unsticky');*/
                $storySocial.waypoint('destroy');
                $storyTakeAction.waypoint('destroy');

                $('.is-long, .is-open').removeClass('is-long is-open');
            }
        };


        enquire.register("screen and (max-width: 767px)", mobile).register("screen and (min-width: 768px)", desktop);



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

        // take action thank you
        function toggleThankYou() {
            var $taAction = $('.take-action__action'),
                $taThankYou = $('.take-action__thank-you');

            $taAction.toggleClass('is-hidden');

            window.setTimeout(function () {
                $taAction.toggleClass('hide');

                $taThankYou.toggleClass('show');
                $taThankYou.toggleClass('is-hidden');
            }, 300);
        }

        // take action back from thank you
        $body.on('click.taBack', '.take-action__social_back', function(e){
            toggleThankYou();

            e.preventDefault();
        });

        // take action submission
        $body.on('click.taSubmit', '.take-action__submit', function (e) {
            toggleThankYou();

            $(window).off('.taSubmit');

            if(!$(this).hasClass('icon_external')){
                e.preventDefault();
            }

        });

        // change org take action
        $('#change-org-petition').submit(function (e) {
            e.preventDefault();
        }).validate({ submitHandler:  function(form){
                var $form = $(form),
                    $formErrors = $form.find('.form-errors'),
                    url = '/wp-admin/admin-ajax.php?action=sign_petition&cta_id=' + $form.attr('data-cta-id');

                $formErrors.empty().addClass('hide');
                $.post(url, $form.serialize())
                    .done(function () {
                        toggleThankYou();
                    })
                    .fail(function (data) {
                        var messages = data.responseJSON.messages;
                        if(messages) {
                            $formErrors.removeClass('hide').html(messages[0]);
                        }
                    });
            }
            });

        // tweet a politician
        function parseReps(data) {
            var officialsById = {};
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

                if(official.channels) {
                    $.each(official.channels, function(){
                        if(this.type === 'Twitter') {
                            official.twitter = this.id;
                            return false;
                        }
                    });
                }
            });

            return $.map(officialsById, function(official) { return official.twitter ? official : null; });
        }

        function lookupReps(address, success, error) {
            $.ajax({
                url: 'https://www.googleapis.com/civicinfo/us_v1/representatives/lookup?key=' + window.googleApiKey,
                type: 'POST',
                contentType: 'application/json; charset=utf-8',
                data: JSON.stringify({ address: address }),
                dataType: 'json',
                success: function(data) {
                    if(data.status === 'success') {
                        success(parseReps(data));
                    } else {
                        error(data);
                    }
                },
                error: function(data) {
                    error(data.responseJSON);
                }
            });
        }

        function renderReps(reps, tweetUrl, tweetMessage) {
            var $politicians = $('#tweet-a-politician').empty();
            $.each(reps, function(){
                $politicians.append(politicianTemplate(this, tweetUrl, tweetMessage));
            });
            $('#tweet-a-politician-container').show();
        }

        var $politicianLookup = $('#politician-lookup'),
            lookupValidator = $politicianLookup.validate({
                submitHandler: function(form){
                    var $form = $(form),
                        $modal = $form.closest('.take-action__full').closest('.modal'),
                        $tweet = $('#tweet-message');

                    lookupReps($form.find('[name=ta-address]').val(), function(reps) {
                        renderReps(reps, $tweet.attr('data-tweet-url'), $tweet.attr('data-tweet-message'));
                    }, function(data) {
                        if(data.status === 'addressUnparseable') {
                            lookupValidator.showErrors({
                                "ta-address": "Sorry we don't recognize this address"
                            });
                        } else if(data.error) {
                            lookupValidator.showErrors({
                                "ta-address": "We are unable to look up addresses at this time. Please try again later"
                            });
                        }
                    });

                    if($modal.length) {
                        fitTakeAction($modal);
                    }
                }
            });

        $politicianLookup.submit(function (event) {
            event.preventDefault();
        });

        function politicianTemplate(politician, shortUrl, message) {
            var twitterUrl = 'https://twitter.com/share?url='
                + encodeURIComponent(shortUrl) + '&text=' +
                encodeURIComponent('@' + politician.twitter + ' ' + message) + '&via=nationswell';

            return  twigs['views-client/politician.twig'].render({ politician: politician,  twitterUrl: twitterUrl });
        }


        $body.on('click', '[data-track]', function(){

            var $target = $(this),
                module = getModule($target),
                config = $target.data('track'),
                tag = $target.prop("tagName"),

                data = $.extend({
                    moduleName: module ? module.name : '',
                    url:  tag === 'A' ? $target.attr('href') : '',
                    action: 'click'
                }, config);

            events.trigger('track',[data]);
        });

        function getModule ($element){
            return $element.closest('[data-module]').data('module');
        }
    });
})(jQuery);