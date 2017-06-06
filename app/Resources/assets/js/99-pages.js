
app.pagesController = app.pagesController || {};
app.pagesController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    closeMap : function () {
        
        // On offer detail page : close Map (only on <= 768 devices)
        var $closeMap = $('.closeMap');
        if ($closeMap.length > 0) {
            $('body').on(app.clickEvent, '.closeMap', function(){
                $('#offer-map').removeClass('is-active');
            });
        }
    },
    
    moveSubofferPurchase : function () {
        
        // On offer detail page : move purchase button in sub offers accordion for <=768 devices
        var vpWidth = function() {
            return $( window ).width();
            };
        var $purchaseSuboffer = $('.subOfferSummary .purchaseButton');
        
        moveBtn();
        
        $( window ).resize(function() {
            moveBtn();
        });
        
        function moveBtn() {
            if (vpWidth() <=768) {
                $purchaseSuboffer.each(function(){
                    $this = $(this);
                    $subOfferCtn = $this.parents('.subOfferItem').find('.subOfferCtn');
                    
                    if (!$this.parent().hasClass('subOfferCtn')) {
                        $this.appendTo($subOfferCtn);
                    }
                });
            }
            else {
                $purchaseSuboffer.each(function(){
                    $this = $(this);
                    $initialParent = $this.parents('.subOfferItem').find('.subOfferSummary');
                    
                    if (!$this.parent().hasClass('subOfferSummary')) {
                        $this.appendTo($initialParent);
                    }
                });
            }
        }
    },
    
    showSubCats : function () {
        var $subCats = $('.resultsSubCats'),
            $subCatsBtn = $('.subCatSelector'),
            $subCatsList = $('.subCatsList');
        if($subCatsBtn.length > 0) {
            $subCatsBtn.on('click', function(){
                $subCats.toggleClass('is-active');
            });
            
            $(document).on(app.clickEvent, function(e){
                $target = $(e.target);
                if (!($target.hasClass('subCatLink')) && !($target.hasClass('subCatSelector'))) {
                    $subCats.removeClass('is-active');
                }
            });
            
            $subCatsList.on('click', '.subCatLink', function(e) {
                console.log(this, e.target);
                var $activeSubCat = $(this);
                $subCatsBtn.text($activeSubCat.find('.subCatName').text());
                $subCatsList.find('.subCatItem').removeClass('is-current');
                $activeSubCat.parents('.subCatItem').addClass('is-current');
            });
        }
    },
    
    showFilters : function () {
        var $filters = $('.resultsFilters'),
            $filterBtn = $('.filtersSelector'),
            $filtersCtn = $('.filtersCtn');
        
        if($filterBtn.length > 0) {
    
        $filtersCtn.append('<button class="closeFilters">Fermer</button>');
            $filterBtn.on('click', function(){
                $filters.addClass('is-active');
                $('body').addClass('active-overlay-classic');
            });
            var $closeFilters = $('.closeFilters');
            if ($closeFilters.length > 0) {
                $('body').on('click', '.closeFilters', function(){
                    $('#filter-results').removeClass('is-active');
                    $('body').removeClass('active-overlay-classic');
                });
            }
            $('.overlay-classic').on(app.clickEvent, function(e){
                $('#filter-results').removeClass('is-active');
                $('body').removeClass('active-overlay-classic');
            });
        }
    },
    
    displayMode : function () {
        var $displayBtn = $('.changedisplayMode .displayBtn');
        
        if($displayBtn.length > 0) {
    
            $displayBtn.on('click', function(e){
                
                // toggle buttons class
                $displayBtn.removeClass('is-active');
                $(e.target).addClass('is-active');
                
                // change grid classes
                var $activeBtn = $('.changedisplayMode .displayBtn.is-active'),
                    $offersList = $('.offersList');
                if ($activeBtn.hasClass('icon-th-list')) {
                    $offersList.removeClass('grid-3 grid-medium-2 grid-small-2').addClass('offersList-horiz');
                    $offersList.find('.offerPhoto').addClass('offerPhoto-wide');
                }
                else if ($activeBtn.hasClass('icon-th-thumb')) {
                    $offersList.addClass('grid-3 grid-medium-2 grid-small-2').removeClass('offersList-horiz');
                    $offersList.find('.offerPhoto').removeClass('offerPhoto-wide');
                }
            });
        }
    },
    
    cartGift : function () {
        var $checkGift = $('.orderSummary .cartItemGift input[type="checkbox"]');
        
        $checkGift.each(function() {
            if ($(this).is(':checked')) {
                $(this).parents('.cartItem').addClass('is-gift');
            }
        });
        
        $checkGift.on('change', function(e) {
            var $check = $(e.target);
            if ($check.is(':checked')) {
                $check.parents('.cartItem').addClass('is-gift');
            }
            else {
                $check.parents('.cartItem').removeClass('is-gift');
            }
        });
    },
    
    cartAccordion : function () {
        $( ".accordion.processSteps" ).accordion( "option", "active", -1 );
    },
    
    formSponsorship : function () {
        var $addBtn = $('#add-email-address'),
            $emailFld = $('.sponsorshipForm .sponsorshipMail'),
            emails = [],
            emailIndex = 1;
    
            emails[emailIndex] = $emailFld;
    
            $addBtn.on('click', function(e){
                emailIndex += 1;
                emails[emailIndex] = $emailFld.clone().insertBefore($addBtn);
                emails[emailIndex].find('.fldLabel').attr('for', 'fld-mail-'+emailIndex).text('E-mail ' + emailIndex + ':');
                emails[emailIndex].find('.fld').attr('id', 'fld-mail-'+emailIndex).val('').after('<button class="removeEmailAddress icon-minus-circled"><span>Supprimer</span></button>');
                
                emails[emailIndex].find('.removeEmailAddress').on('click', function(me){
                    $(me.target).parents('.sponsorshipMail').remove();
                    me.preventDefault();
                });
                
                e.preventDefault();
            });
    },
    
    cartPayment : function () {
        var $payChoice = $('.paymentChoice'),
            $btnPay = $('.paymentChoiceBtn'),
            $payForm = $('.paymentForm');

        $payForm.css('min-height', $payChoice.height() - 20);
    
        $btnPay.on('click', $payChoice, function(e){
            $btn = $(e.target);
            $btn.siblings().removeClass('is-active');
            $btn.addClass('is-active');

            var $otherForms = $('#'+$btn.siblings().data('link'));
            $payForm.removeClass('is-active');
                

            var $currentForm = $('#'+$btn.data('link'));
            if ($currentForm) {
                $currentForm.addClass('is-active');
            }
        });
    },
    
    accountTabs: function() {
        
        var $tabs = $('.accountNav > .btn'),
            hash = window.location.hash,
            keepActive = $('.accountNav #activeTab'),
            $activeTab;


        // Au chargement
        $( document ).ready(function() {
            if (hash) {
                if ($('.accountNav > .btn[href="'+ hash +'"]').length > 0) {
                    // Prevents jumping to anchor
                    window.scrollTo(0, 0);         // execute it straight away
                    setTimeout(function() {
                        window.scrollTo(0, 0);     // run it a bit later also for browser compatibility
                    }, 1);

                    $activeTab = $('.accountNav > .btn[href="'+ hash +'"]');
                    setActiveTab();
                }
            }
            else if (keepActive.val() != '') {
                $activeTab = $('.accountNav > .btn[href="'+ keepActive.val() +'"]');
                setActiveTab();
            }
            else {
                $activeTab = false;
            }
        });
        
        // Entrée par les onglets de la page Mon compte
        $('.accountNav').on('click', '.btn', function(e){
            $activeTab = $(e.target);
            setActiveTab();
            
            if ($(window).width() > 960) {
                $activeTab.blur();
                keepActive.val($activeTab.attr('href'));
                e.preventDefault();
            }
        });
        
        // Entrée par une ancre (ex. tooltip profil dans header lorsqu'on est déjà sur la page Mon compte)
        $( window ).on( 'hashchange', function(e) {
            if ($('.accountNav > .btn[href="'+ window.location.hash +'"]').length > 0) {
                // Prevents jumping to anchor
                window.scrollTo(0, 0);         // execute it straight away
                setTimeout(function() {
                    window.scrollTo(0, 0);     // run it a bit later also for browser compatibility
                }, 1);

                // Ferme la tooltip profil dans header
                $('body').trigger('click');

                hash = window.location.hash;
                keepActive.val(hash);
                $activeTab = $('.accountNav > .btn[href="'+ keepActive.val() +'"]');

                setActiveTab();
            }
        });
        
        function setActiveTab () {
            $tabs.removeClass('btn-primary');
            $activeTab.addClass('btn-primary');
            
            var $activeSection = $(keepActive.val());
            if ($activeSection) {
                $('.accountSection').removeClass('is-active');
                $($activeTab.attr('href')).addClass('is-active');
            }
        }
    }
        
};

$(document).ready(function(){
    
    // Rubriques
    if ($('.siteBody').hasClass('category')) {
        app.pagesController.defaultAction.showSubCats();
        app.pagesController.defaultAction.showFilters();
        app.pagesController.defaultAction.displayMode();
    }
    
    // Détail offre
    if ($('.siteBody').hasClass('singleOffer')) {
        app.pagesController.defaultAction.closeMap();
        app.pagesController.defaultAction.moveSubofferPurchase();
    }
    
    // Panier
    if ($('.siteBody').hasClass('cart')) {
        app.pagesController.defaultAction.cartGift();
        app.pagesController.defaultAction.cartAccordion();
        app.pagesController.defaultAction.formSponsorship();
        app.pagesController.defaultAction.cartPayment();
    }
    
    // Mon compte
    if ($('.siteBody').hasClass('userAccount')) {
        app.pagesController.defaultAction.accountTabs();
        app.pagesController.defaultAction.formSponsorship();
    }
});
            