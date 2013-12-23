events.on('track', function(e, module, action){
   _gaq.push(['_trackEvent', module.category, action.name, module.name]);
});

events.on('nav-open', function(){
    _gaq.push(['_trackEvent', 'nav', 'open', 'top-nav']);
});

events.on('newsletter-subscribed', function(e, module){
    _gaq.push(['_trackEvent', 'newsletter', 'subscribed', module.name]);
});

events.on('newsletter-subscribe-fail', function(e, module, resp){
    _gaq.push(['_trackEvent', 'newsletter', 'subscribe', module.name, resp.msg]);
});