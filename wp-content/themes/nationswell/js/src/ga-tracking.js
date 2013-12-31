(function(){
    function track() {
        if (typeof _gaq != "undefined") {
            var event = ['_trackEvent'], i, n;
            for(i = 0, n = arguments.length; i < n; i++){
                if(arguments[i] !== undefined) {
                    event.push(arguments[i]);
                }
            }
            console.log(event);
            _gaq.push(event);
        }
    }

    events.on('track', function(e, data) {
        track(data.moduleName, data.action, data.label || data.url, data.value || data.position);
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
