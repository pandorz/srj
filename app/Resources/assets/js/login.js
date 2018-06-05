
app.loginController = app.loginController || {};
app.loginController.defaultAction = {

    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */

    initlogin: function() {
        $('body').on( 'click', '#_submit', function(e){
            var $form   = $('.js-form-login');
            var $button = $(this);
            e.preventDefault();

            if (!$button.hasClass('disabled')) {
                $button.addClass('wait-cursor disabled');
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: "json",
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        var $errorMessage = $('.js-form_login_error');
                        $errorMessage.find('.alert').html(err.message);
                        $errorMessage.show();
                        $button.removeClass('wait-cursor disabled');
                    },
                    success: function (data) {
                        window.location.href = data.path;
                    }
                });
            }
        });

    }
};

$(document).ready(function(){
    if ('.js-form-login') {
        app.loginController.defaultAction.initlogin();
        $('.js-form_login_error').hide();
    }
});
