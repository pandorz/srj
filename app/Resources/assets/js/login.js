
app.loginController = app.loginController || {};
app.loginController.defaultAction = {

    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */

    initlogin: function() {
        $('body').on( 'click', '#_submit', function(e){
            var $form = $('.js-form-login');
            e.preventDefault();
            $.ajax({
                type        : $form.attr( 'method' ),
                url         : $form.attr( 'action' ),
                data        : $form.serialize(),
                dataType    : "json",
                success     : function(data, status, object)
                {
                    console.log("aqui");
                    console.log(data);
                    if (data.message) {
                        var $errorMessage = $('.js-form_login_error');
                        $errorMessage.find('.alert').html(data.message);
                        $errorMessage.show();
                    }
                }
            });
        });

    }
};

$(document).ready(function(){
    if ('.js-form-login') {
        app.loginController.defaultAction.initlogin();
        $('.js-form_login_error').hide();
    }
});
