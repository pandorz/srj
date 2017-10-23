"use strict";
(function(window) {
    window.AdminComponent = function() {
        this.$searchEmplacementContainer = $('.js-search-emplacement-container');
        this.initAdminForm();
    };

    $.extend(window.AdminComponent.prototype, {
        initAdminForm: function () {
            var $emplacementContainer = $('.js-emplacement-container');
            var self = this;

            if (this.$searchEmplacementContainer.length) {
                self.constructAdress();

                $emplacementContainer.on('change', '.js-data-emplacement', function () {
                    self.constructAdress();
                });
            }
        },

        constructAdress: function () {
            if (this.$searchEmplacementContainer.length) {
                var $emplacementInput = this.$searchEmplacementContainer.find('.js-search-emplacement-input');
                var adresseComplete = '';

                $('.js-data-emplacement').each(function () {
                    adresseComplete += $(this).val() + ' ';
                });

                $emplacementInput.val(adresseComplete);
            }
        }
    });


})(window);

$(document).ready(function() {
    var adminComponent = new AdminComponent();
});