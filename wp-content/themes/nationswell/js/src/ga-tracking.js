(function(){
    function track() {
        if (typeof _gaq != "undefined") {
            _gaq.push(['_trackEvent'].concat(arguments));
        }
    }

    events.on('track', function(e, module, action) {
        track(action.category || module.category, action.name, module.name);
    });

    events.on('nav-open', function(){
        track('nav', 'open', 'top-nav');
    });

    events.on('nav-search-open', function(e, module){
        track('search', 'open', module.name);
    });


    events.on('nav-more-stories-open', function(e, module){
        track('more-stories', 'open', module.name);
    });


    events.on('nav-subscribe-open', function(e, module){
        track('newsletter', 'open', module.name);
    });

    events.on('newsletter-subscribed', function(e, module){
        track('newsletter', 'subscribed', module.name);
    });

    events.on('newsletter-subscribe-fail', function(e, module, resp){
        track('newsletter', 'subscribe', module.name, resp.msg);
    });
})();
