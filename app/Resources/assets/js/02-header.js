app.headerController = app.headerController || {};
app.headerController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        this.showMainNav();
    },
    
    showMainNav : function () {
        var $toggleNav = $('.toggleNav');

        if($toggleNav.length > 0) {

            // Toggle nav + overlay
            $('.siteHeader').append('<div id="header-overlay" class="overlay overlay-header"></div>');
            $toggleNav.on(app.clickEvent, function(){
                $toggleNav.toggleClass('is-active');
                $('body').toggleClass('no-scroll');
                $('html').toggleClass('active-overlay-header');
            });
            $('#header-overlay').on(app.clickEvent, function(){
                $toggleNav.removeClass('is-active');
                $('body').removeClass('no-scroll');
                $('html').removeClass('active-overlay-header');
            });

            // Sub menus
            $('.has-subMenu').each(function(){
                var $menu = $(this).children('ul'),
                    $menuParentItem = $(this),
                    $menuParentLink = $(this).children('a');

                $menu.hide();
                $menuParentLink.on(app.clickEvent, function(e) {
                    $menuParentItem.toggleClass('is-active');
                    $menu.animate({
                        height : "toggle"
                    }, 300, function() {
                        // Animation complete.
                    });

                    if (! $menuParentItem.hasClass('is-active') && $menu.find('.has-subMenu').length > 0) {
                        $menu.find('ul').animate({ // close subSubMenu
                            height : "hide"
                        }, 300, function() {
                            // Animation complete.
                        });
                    }
                });
            });

            // Click outside Nav (>1100px)
            $('body').on('click', function(e) {
                $target = $(e.target);
                if (! $target.hasClass('mainNavItem') && ! $target.parents().hasClass('mainNavItem') ) {
                    $('.has-subMenu').find('ul').animate({ // close subSubMenu
                        height : "hide"
                    }, 300, function() {
                        // Animation complete.
                    });
                }
            });
            
        }
    },

};