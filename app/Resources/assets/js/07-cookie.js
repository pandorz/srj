app.cookieController = app.cookieController || {};
app.cookieController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        var self = this;
        $('.accept_all_cookies').on('click', function(e) {
            self.acceptCookies(true, self);
            self.closeBandeau();
        } );

        self.checkServicesChoices(self);

        $('body').on( 'click', '.accept_custom_cookies', function( event ) {
            self.acceptCookies(false, self);
            self.closeModal();
            self.closeBandeau();
        });

        $('body').on( 'click', '.btn-modal-close', function( event ) {
           self.closeModal();
        });
    },

    acceptCookies: function (all, self) {
        var $elem = $('body').find('.switch');
        $elem.each(function (i) {
            var $checkbox = this.getElementsByTagName('input')[0];
            if (all === true) {
                self.setCookie($checkbox.getAttribute('name'), 1, 30);
            } else {
                self.setCookie($checkbox.getAttribute('name'), ($checkbox.checked?1:0), 30);
            }
        });
        self.setCookie('bandeau', 1, 30);
    },

    checkServicesChoices : function (self) {
        $('body').on( 'click', '.switch', function( event ) {
            var $checkbox = this.getElementsByTagName('input')[0];
            if ($checkbox.checked) {
                $checkbox.checked = false;
                if ($checkbox.getAttribute('name') !== 'all_services') {
                    document.getElementById("all_services").checked = false;
                }
            } else {
                $checkbox.checked = true;
                if ($checkbox.getAttribute('name') !== 'all_services' && self.allServicesAreChecked()) {
                    document.getElementById("all_services").checked = true;
                }

                if ($checkbox.getAttribute('name') === 'all_services') {
                    self.checkAllServices();
                }
            }
        } );
    },

    closeBandeau : function () {
        $('.cookieBandeau').hide();
    },

    allServicesAreChecked: function () {
        return document.getElementById("twitter_service").checked && document.getElementById("facebook_service").checked && document.getElementById("google_service").checked;
    },

    checkAllServices: function () {
        var $elem = $('body').find('.switch');
        $elem.each(function (i) {
            this.getElementsByTagName('input')[0].checked = true;
        });
    },

    closeModal: function () {
        $(document.getElementById('modal-close')).trigger('click');
    },

    setCookie: function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },

    getCookie: function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
};