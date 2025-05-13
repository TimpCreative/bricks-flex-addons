(function($){
  function initSingleBackToTop($this, attempt) {
    attempt = attempt || 0;
    var scrollOffset = parseInt($this.data('scroll-offset') || 200, 10);
    var $border = $this.find('.bfa-back-to-top-border');
    if(!$border.length) return;
    var inBuilder = typeof BRICKS_ENV !== 'undefined' && BRICKS_ENV === 'builder';
    window.requestAnimationFrame(function() {
      window.requestAnimationFrame(function() {
        var isCircle = $border.is('circle');
        var length = 0;
        if (isCircle) {
          length = $border[0].getTotalLength();
        } else if ($border.is('rect') || $border.is('path')) {
          length = $border[0].getTotalLength();
        }
        if (length === 0 && attempt < 5) {
          setTimeout(function() { initSingleBackToTop($this, attempt + 1); }, 100);
          return;
        }
        console.log('Border length for', $this[0], ':', length);
        var ticking = false;
        function setProgress(){
          if(inBuilder) {
            if($border.length && length) {
              $border.css({'stroke-dashoffset': 0});
            }
            return;
          }
          var scrollTop = $(window).scrollTop();
          var docHeight = $(document).height() - $(window).height();
          var percent = docHeight > 0 ? Math.min(scrollTop / docHeight, 1) : 0;
          if($border.length && length) {
            var offset = length * (1 - percent);
            $border.css({
              'stroke-dashoffset': offset
            });
          }
        }
        function toggleBtn(){
          if(window.scrollY > scrollOffset){
            $this.fadeIn();
          } else {
            $this.fadeOut();
          }
        }
        $(window).off('scroll.bfaBackToTop').on('scroll.bfaBackToTop', function(){
          if(!ticking){
            window.requestAnimationFrame(function(){
              toggleBtn();
              setProgress();
              ticking = false;
            });
            ticking = true;
          }
        });
        $this.off('click.bfaBackToTop').on('click.bfaBackToTop', function(e){
          e.preventDefault();
          $('html, body').animate({scrollTop:0}, 600, 'swing');
        });
        // Initial state
        toggleBtn();
        setProgress();
      });
    });
  }
  function initBackToTop($scope){
    var $btn = $scope ? $scope.find('.bfa-back-to-top') : $('.bfa-back-to-top');
    if(!$btn.length) return;
    $btn.each(function(){
      initSingleBackToTop($(this));
    });
  }
  $(document).ready(function(){ initBackToTop(); });
  // Bricks event for elements rendered
  if(typeof bricks !== 'undefined' && typeof bricks.on === 'function'){
    bricks.on('elementsRendered', function($element){
      initBackToTop($element);
    });
    bricks.on('frontend', function(){ setTimeout(function(){ initBackToTop(); }, 100); });
  } else if(typeof window.bricksFrontend !== 'undefined') {
    window.bricksFrontend.on('init', function(){ setTimeout(function(){ initBackToTop(); }, 100); });
  }
})(jQuery); 