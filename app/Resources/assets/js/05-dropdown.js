
app.dropdownController = app.dropdownController || {};
app.dropdownController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        var $dropAnchor = $('.has-dropdown');
        if ($dropAnchor.length > 0) {
            $dropAnchor.each(function() {
                var $anchor = $(this),
                    dropID = $anchor.attr('href'),
                    $dropdown
                ;
                // Creates overlay's <div>
                if ($('.overlay-mobile').length < 1) {
                    $('body').append('<div class="overlay-mobile"></div>');
                }
                
                // Check if the href's first character is a "#"
                if (dropID.substr(0, 1) == '#') {
                    $dropdown = $(dropID);
                    
                    $dropdown.wrapInner('<div class="dropdownCtn"></div>');

                    // Creates close button
                    $dropdown.prepend('<button class="dropdown-close"><span class="u-hiddenVisually">Fermer</span></button>');
                    $dropdown.on('click', '.dropdown-close', function() {
                        app.dropdownController.defaultAction.hideDropdown($dropdown);
                    });
                    
                    // Check if the dropdown has a title
                    if ($dropdown.find('.dropdownTitle').length > 0) {
                        $dropdown.addClass('has-title');
                    }
                    
                    $anchor.on('click', function(e){
                        e.preventDefault();
                        if ($dropdown.hasClass('is-active')) {
                            app.dropdownController.defaultAction.hideDropdown($dropdown);
                        }
                        else {
                            app.dropdownController.defaultAction.showDropdown($dropdown);
                        }
                   });
                }
            });
            
            // Hide all .dropdown's on click anywhere but a .has-dropdown link (or children)
            $(document).on(app.clickEvent, function(e){
                $target = $(e.target);
                if (($target.parents('.dropdownGroup').length < 1) && !($target.hasClass('has-dropdown'))) {
                    app.dropdownController.defaultAction.hideAllDropdowns();
                }
            });
        }
    },
    
    showDropdown : function ($dropdown) {
        app.dropdownController.defaultAction.hideAllDropdowns();
        $('body').addClass('active-overlay-mobile');
        $dropdown.addClass('is-active').attr('aria-hidden', 'false');
    },
    
    hideDropdown : function ($dropdown) {
        $('body').removeClass('active-overlay-mobile');
        $dropdown.removeClass('is-active').attr('aria-hidden', 'true');
    },
    
    hideAllDropdowns : function () {
        if ($('.dropdown.is-active').length > 0) {
            $('body').removeClass('active-overlay-mobile');
            app.dropdownController.defaultAction.hideDropdown($('.dropdown.is-active'));
        }
    }
};

$(document).ready(function(){
    app.dropdownController.defaultAction.init();
});
