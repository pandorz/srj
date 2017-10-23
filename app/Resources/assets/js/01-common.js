
app.commonController = app.commonController || {};
app.commonController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        
        // Touch detection
        if (!('ontouchstart' in document.documentElement)) {
            $('html').removeClass('touch').addClass('no-touch');
        }
        else {
            $('html').removeClass('no-touch').addClass('touch');
        }
        
        // Enable transition after DOM is loaded
        $(document).ready(function(){
            $("body").removeClass("preload");
        });

        // Object-fit polyfill
        //$(function () { objectFitImages() });

        // Back to top link
        this.backToTop();
        
    },
    
    backToTop : function () {
        var $topLink = $('.backToTop');
        if ($topLink.length > 0) {
            
            var scrollOffset = function() { return $(document).scrollTop(); }
            
            $topLink.on('click', function(){
                $('html, body').animate({ scrollTop:0 }, 500);
            });
            
            $(document).on('scroll', function() {
                if (scrollOffset() > $(window).innerHeight() /2 ) {
                    $('body').addClass('active-backToTop');
                }
                else {
                    $('body').removeClass('active-backToTop');
                }
            });
        }
    }
};

$(document).ready(function(){
    app.commonController.defaultAction.init();
});
