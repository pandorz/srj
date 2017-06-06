
app.accordionController = app.accordionController || {};
app.accordionController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        var $accordion = $('.accordion');
        if ($accordion.length > 0) {
            $accordion.accordion({
                heightStyle: "content",
                header: '.accordionTitle'
            });
            $('.accordion .dropdown').on('click', function(e){ e.stopPropagation(); });
        }
    },
        
};

$(document).ready(function(){
    app.accordionController.defaultAction.init();
});
