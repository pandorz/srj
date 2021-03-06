
app.grecaptchaController = app.grecaptchaController || {};
app.grecaptchaController.defaultAction = {

    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */

    initGrecaptcha: function($scope) {
        $scope =  (typeof $scope !== 'undefined') ?  $scope : $('body');
        var self = this;

        $scope.find('.js-form-grecaptcha').each(function() {
            var $grecaptchaForm      = $(this);
            var $grecaptchaButton    = $grecaptchaForm.find('.js-button-grecaptcha');
            var $grecaptchaContainer = $grecaptchaForm.find('.js-container-grecaptcha');
            var grecatchaId = grecaptcha.render($grecaptchaContainer[0], {
                'sitekey': $grecaptchaButton.attr('data-grecaptcha-key'),
                'size': 'invisible',
                'badge': 'inline',
                'callback': function () {
                    $grecaptchaForm.submit();
                }
            });

            $grecaptchaButton.attr('data-grecaptcha-id', grecatchaId);
            $grecaptchaButton.click(self.executeGrecaptcha).bind(self);
        });

    },

    executeGrecaptcha: function(e) {
        e.preventDefault();
        grecaptcha.execute($(e.currentTarget).attr('data-grecaptcha-id'));
    }
};

$(document).ready(function(){
    if ('.js-form-grecaptcha') {
        app.grecaptchaController.defaultAction.initGrecaptcha();
        $('.js-container-grecaptcha').hide();
    }
});
