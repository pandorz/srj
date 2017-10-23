
app.sliderController = app.sliderController || {};
app.sliderController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        var $slider = $('.mediaSlider');
        if ($slider.length > 0) {
            $slider.slick({
                dots: true
            });
        }
        
        var $htmlSlider = $('.htmlSlider');
        if ($htmlSlider.length > 0) {
            $htmlSlider.slick({
                prevArrow: '<button type="button" class="slick-prev icon-arrow-left">Précédent</button>',
                nextArrow: '<button type="button" class="slick-next icon-arrow-right">Suivant</button>'
            });
        }
    }
};

$(document).ready(function(){
    app.sliderController.defaultAction.init();
});
