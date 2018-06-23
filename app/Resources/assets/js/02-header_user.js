app.headerUserController = app.headerUserController || {};
app.headerUserController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        this.showUserNav();
    },
    
    showUserNav : function () {
        var $profilPicture  = $('#profil-picture');
        var $userNav        = $('.userNav > nav');
        $('#navToggleUser a').click(function(e){
            e.preventDefault();

            $userNav.slideToggle('medium');
            $profilPicture.toggleClass('menuUp menuDown');
        });

        $(window).resize(function() {
            if($( window ).width() >= '600') {
                $userNav.css('display', 'block');

                if($profilPicture.attr('class') === 'menuDown') {
                    $profilPicture.toggleClass('menuUp menuDown');
                }
            }
            else {
                $userNav.css('display', 'none');
            }
        });

        $('.userNav > nav > ul > li > a').click(function(e) {
            if($( window ).width() <= '600') {
                if($(this).siblings()) {
                    $(this).siblings().slideToggle('fast')
                    $(this).children('.toggle').html($(this).children('.toggle').html() === 'close' ? 'expand' : 'close');
                }
            }
        });
    }
};