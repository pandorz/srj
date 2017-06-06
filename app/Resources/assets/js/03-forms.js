
app.formsController = app.formsController || {};
app.formsController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        if ($('select').length > 0) {
            // Transform selects on no-touch devices
            if ($('html').hasClass('touch') && $(window).width() <= 960) {
                $('select').customSelect();
            }
            
            // Transform selects on touch devices
            else {
                $('select').each(function(){
                    $(this).select2({
                        // Hide the search box
                        minimumResultsForSearch: Infinity,
                        dropdownParent: $(this).parent('.formSelect'),
                    });
                });
            }
        }
        
        if ($('[type="checkbox"]').length > 0) {
            this.transformCheck();
        }
        if ($('[type="radio"]').length > 0) {
            this.transformRadio();
        }
        if ($('.formSpinner').length > 0) {
            this.transformSpinner();
        }
        
        if ($('.formSlider').length > 0) {
            this.transformSlider();
        }
    },
    
    transformCheck : function () {
        $checkbox = $('[type="checkbox"]');
        $checkbox.each(function(){
            $check = $(this);
            $check.wrap('<span class="dummyCheck"></span>').after('<span class="dummySelected"></span>');
        });
    },
    
    transformRadio : function () {
        $radio = $('[type="radio"]');
        $radio.each(function(){
            $radio = $(this);
            $radio.wrap('<span class="dummyRadio"></span>').after('<span class="dummySelected"></span>');
        });
    },
    
    transformSpinner : function () {
        $('.formSpinner').spinner();
    },
    
    transformSlider : function () {
        var formSlider = document.getElementsByClassName('formSlider');
        
        Array.prototype.forEach.call(formSlider, function(slider) {
        
            // Initialize slider
            noUiSlider.create(slider, {
                start: [ 20, 80 ],
                step: 1,
                tooltips: [ wNumb({ decimals: 0, postfix: '&nbsp;&euro;'}), wNumb({ decimals: 0, postfix: '&nbsp;&euro;'}) ],
                connect: true,
                range: {
                    'min': 0,
                    'max': 100
                }
            });

            var fromID = slider.getAttribute('data-from-id'),
                toID = slider.getAttribute('data-to-id'),
                inputFrom = document.getElementById(fromID),
                inputTo = document.getElementById(toID);

            slider.noUiSlider.on('update', function( values, handle ) {

                var value = values[handle];
                inputFrom.value = values[0];
                inputTo.value = values[1];
            });

            inputFrom.addEventListener('change', function(){
                slider.noUiSlider.set([this.value, null]);
            });

            inputTo.addEventListener('change', function(){
                slider.noUiSlider.set([null, this.value]);
            });


        });
    },
        
};

$(document).ready(function(){
    app.formsController.defaultAction.init();
});
