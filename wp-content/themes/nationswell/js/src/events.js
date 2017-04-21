//A super simple global event helper
window.events =
    (function() {
        var o = jQuery({});

        return {
            on: function() {
                o.on.apply(o, arguments);
            },

            off: function() {
                o.off.apply(o, arguments);
            },

            trigger: function() {
                o.trigger.apply(o, arguments);
            }
        };
    })();