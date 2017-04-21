var s = skrollr.init({forceHeight: false,
          mobileCheck: function() {
            //hack - forces mobile version to be off
            return false;
        }
});

$(document).ready(function(){
  function filterPath(string) {
  return string
    .replace(/^\//,'')
    .replace(/(index|default).[a-zA-Z]{3,4}$/,'')
    .replace(/\/$/,'');
  }
  var locationPath = filterPath(location.pathname);
  var scrollElem = scrollableElement('html', 'body');
 
  $('a[href*=#]').each(function() {
    var thisPath = filterPath(this.pathname) || locationPath;
    if (  locationPath == thisPath
    && (location.hostname == this.hostname || !this.hostname)
    && this.hash.replace(/#/,'') ) {
      var $target = $(this.hash), target = this.hash;
      if (target) {
        var targetOffset = $target.offset().top;
        $(this).click(function(event) {
          event.preventDefault();
          $(scrollElem).animate({scrollTop: targetOffset}, 800, function() {
            location.hash = target;
          });
        });
      }
    }
  });
 
  // use the first element that is "scrollable"
  function scrollableElement(els) {
    for (var i = 0, argLength = arguments.length; i <argLength; i++) {
      var el = arguments[i],
          $scrollElement = $(el);
      if ($scrollElement.scrollTop()> 0) {
        return el;
      } else {
        $scrollElement.scrollTop(1);
        var isScrollable = $scrollElement.scrollTop()> 0;
        $scrollElement.scrollTop(0);
        if (isScrollable) {
          return el;
        }
      }
    }
    return [];
    }
  
   var waypoints = $('.core-focus li.one').waypoint(function(direction) {
    if (direction === 'down') {
      $('.core-focus li.one').addClass('on');
    }
    else {
      $('.core-focus li.one').removeClass('on');
    }
  }, {
    offset: '75%'
  }) 

   var waypoints = $('.core-focus li.two').waypoint(function(direction) {
    if (direction === 'down') {
      $('.core-focus li.two').addClass('on');
    }
    else {
      $('.core-focus li.two').removeClass('on');
    }
  }, {
    offset: '65%'
  }) 

   var waypoints = $('.core-focus li.three').waypoint(function(direction) {
    if (direction === 'down') {
      $('.core-focus li.three').addClass('on');
    }
    else {
      $('.core-focus li.three').removeClass('on');
    }
  }, {
    offset: '55%'
  }) 
  
   var waypoints = $('.core-focus li.four').waypoint(function(direction) {
    if (direction === 'down') {
      $('.core-focus li.four').addClass('on');
    }
    else {
      $('.core-focus li.four').removeClass('on');
    }
  }, {
    offset: '45%'
  })
  
  $('.filter a').on('click',function(e){
    e.preventDefault();
    $('.filter a').removeClass('active').removeClass('clicked');
    $(this).addClass('clicked').addClass('active');
    var filter = $(this).attr('data-filter');
    $('.events-listings').hide();
    $('.'+filter+'-events').fadeIn();
  });
  
  var slider = $('.bxslider').bxSlider({
    adaptiveHeight: true,
    pager: false,
    auto: false,
    autoHover: true,
    controls: true,
    mode: 'horizontal',
    onSliderLoad: function(){
      $(".testimonial-list li").css("visibility", "visible");
    }
  });

$(document).keydown(function(e){
    if (e.keyCode == 39) // Right arrow 
    {
        slider.goToNextSlide();
        return false;
    }
    else if (e.keyCode == 37) // left arrow
    {
         slider.goToPrevSlide();
        return false;
   }
});

});