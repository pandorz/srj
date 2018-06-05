
app.showhideController = app.showhideController || {};
app.showhideController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        var $moreBtn = $('.shortPost .seeMore');
        if ($moreBtn.length > 0) {
            $moreBtn.on('click', function(e) {
                $target = $(e.target);
                $target.toggleClass('is-active');
                $target.parents('.shortPost').find('.postSummary').toggleClass('moreSummary');
                $target.parents('.shortPost').find('.postMoreText').animate({
                    height : "toggle"
                }, 300, function() {
                    // Animation complete.
                });
            });
        }
    }
};

$(document).ready(function(){
    app.showhideController.defaultAction.init();
});
