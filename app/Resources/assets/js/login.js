
app.loginController = app.loginController || {};
app.loginController.defaultAction = {

    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */

    initlogin: function() {
        var $errorMessage       = $('.js-form_login_error');
        var $errorMessageAlert  = $errorMessage.find('.alert-error');
        $errorMessageAlert.html('');
        $errorMessageAlert.hide();

        $('body').on( 'click', '#_submit_login', function(e){
            var $form   = $('.js-form-login');
            var $button = $(this);
            $errorMessageAlert  = $form.find('.alert-error');
            e.preventDefault();

            if (!$button.hasClass('disabled')) {
                $button.addClass('wait-cursor disabled');
                $errorMessageAlert.html('');
                $errorMessageAlert.hide();
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: "json",
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        $errorMessageAlert.html(err.message);
                        $errorMessageAlert.show();
                        $button.removeClass('wait-cursor disabled');
                    },
                    success: function (data) {
                        window.location.href = data.path;
                    }
                });
            }
        });
    },

    initPwd: function () {
        var $containerMessage       = $('.js-form_lost_pwd_messages');
        var $errorMessageAlert      = $containerMessage.find('.alert-error');
        var $successMessageAlert    = $containerMessage.find('.alert-success');
        this.resetMessage($successMessageAlert, $errorMessageAlert);
        this.formActionAccessPwd($successMessageAlert, $errorMessageAlert, '_submit_pwd', 'js-form-lost-pwd');
    },

    initAccess: function () {
        var $containerMessage       = $('.js-form_ask-account_messages');
        var $errorMessageAlert      = $containerMessage.find('.alert-error');
        var $successMessageAlert    = $containerMessage.find('.alert-success');
        this.resetMessage($successMessageAlert, $errorMessageAlert);
        this.formActionAccessPwd($successMessageAlert, $errorMessageAlert, '_submit_access', 'js-form-ask-account');
    },

    resetMessage: function ($successMessageAlert, $errorMessageAlert) {
        $errorMessageAlert.html('');
        $successMessageAlert.html('');
        $errorMessageAlert.hide();
        $successMessageAlert.hide();
    },

    showErrorMessage: function($errorMessageAlert, message) {
        $errorMessageAlert.html(message);
        $errorMessageAlert.show();
    },

    showSuccesMessage: function($successMessageAlert, message) {
        $successMessageAlert.html(message);
        $successMessageAlert.show();
    },

    showMessage: function($successMessageAlert, $errorMessageAlert, message, status) {
        if (status !== 200) {
            this.showErrorMessage($errorMessageAlert, message);
        } else {
            this.showSuccesMessage($successMessageAlert, message);
        }
    },

    formActionAccessPwd: function ($successMessageAlert, $errorMessageAlert, idButton, classForm) {
        var self = this;
        $('body').on( 'click', '#'+idButton, function(e){
            var $form   = $('.'+classForm);
            var $button = $(this);
            e.preventDefault();

            if (!$button.hasClass('disabled')) {
                $button.addClass('wait-cursor disabled');
                self.resetMessage($successMessageAlert, $errorMessageAlert);
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: "json",
                    error: function (data, status, error) {
                        var mess = data.responseText;
                        if (data.status !== 200) {
                            mess = JSON.parse(mess);
                        }
                        self.showMessage($successMessageAlert, $errorMessageAlert, mess, data.status);
                        $button.removeClass('wait-cursor disabled');
                    },
                    success: function (data) {
                        self.showMessage($successMessageAlert, $errorMessageAlert, data, 200);
                        $button.removeClass('wait-cursor disabled');
                    }
                });
            }
        });
    },

    initNavButtons: function () {
        var $body = $('body');
        var self = this;

        $body.on( 'click', '.js-show-login-form', function(e) {
            self.showLoginForm();
            self.hideAccesForm();
            self.hideLostPwdForm();
        });

        $body.on( 'click', '.js-show-pwd-form', function(e) {
            self.showLostPwdForm();
            self.hideLoginForm();
            self.hideAccesForm();

        });

        $body.on( 'click', '.js-show-access-form', function(e) {
            self.showAccesForm();
            self.hideLoginForm();
            self.hideLostPwdForm();
        });
    },

    showLoginForm: function () {
        $('.js-form-login').removeClass('u-hidden');
        $('.js-show-login-form').addClass('u-hidden');
        this.initlogin();
    },

    showLostPwdForm: function () {
        $('.js-form-lost-pwd').removeClass('u-hidden');
        $('.js-show-pwd-form').addClass('u-hidden');
        this.initPwd()
    },

    showAccesForm: function () {
        $('.js-form-ask-account').removeClass('u-hidden');
        $('.js-show-access-form').addClass('u-hidden');
        this.initAccess();
    },

    hideLoginForm: function() {
        $('.js-form-login').addClass('u-hidden');
        $('.js-show-login-form').removeClass('u-hidden');
    },

    hideLostPwdForm: function () {
        $('.js-form-lost-pwd').addClass('u-hidden');
        $('.js-show-pwd-form').removeClass('u-hidden');
    },

    hideAccesForm: function () {
        $('.js-form-ask-account').addClass('u-hidden');
        $('.js-show-access-form').removeClass('u-hidden');
    }
};

$(document).ready(function(){
    if ('.js-form-login') {
        app.loginController.defaultAction.initlogin();
        app.loginController.defaultAction.initNavButtons();
    }
});
