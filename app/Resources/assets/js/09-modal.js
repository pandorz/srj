
app.modalController = app.modalController || {};
app.modalController.defaultAction = {
   
    /**
     * Initialisation de la fonction
     * @returns {undefined}
     */
    init : function () {
        
        if ($('.modal').length > 0) {
        
            /*
            * jQuery simple and accessible modal window, using ARIA
            * Website: http://a11y.nicolas-hoffmann.net/modal/
            * License MIT: https://github.com/nico3333fr/jquery-accessible-modal-window-aria/blob/master/LICENSE
            */
           // loading modal ------------------------------------------------------------------------------------------------------------

            // init
            var $modals = $( '.modal' ),
                $body = $( 'body' );

            $modals.each( function(index_to_expand) {
                var $this = $(this) ,
                    index_lisible = index_to_expand+1;

                $this.attr({
                      'id' : 'label_modal_' + index_lisible
                       });

            });

            // jQuery formatted selector to search for focusable items
            var focusableElementsString = "a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]";

            // events ------------------
            $body.on( 'click', '.modal', function( event ) {
                  var $this = $(this),
                      options = $this.data(),
                      $modal_starter_id = $this.attr('id'),
                      $modal_text = options.modalText || '',
                      modal_content_id = typeof options.modalContentId !== 'undefined' ? options.modalContentId : '',
                      $modal_content = typeof options.modalContentId !== 'undefined' ? $('#'+modal_content_id) : undefined,
                      $modal_title = options.modalTitle || '',
                      $modal_code,
                      $modal_overlay;

                // if some ui component must be destroyed
                // Do stuff...


                // insert code at the end
                  $modal_code = '<div id="modal" class="dialog js-modal ' + modal_content_id + '" role="dialog" aria-labelledby="modal-title"><div role="document">';
                  $modal_code += '<button id="modal-close" class="modal-close" data-content-back-id="' + modal_content_id + '" data-focus-back="' + $modal_starter_id + '" title="Fermer la fenÃªtre"><span class="modal-close__text">Fermer la fenÃªtre</span></button>';
                  if ($modal_title !== ''){
                     $modal_code += '<h1 id="modal-title" class="modal-title">' + $modal_title + '</h1>';
                     }

                  if ($modal_text !== ''){
                     $modal_code += '<p>' + $modal_text + '</p>';
                     }
                     else {
                           if (modal_content_id !== '' && $modal_content.length ){
                              $modal_code += '<div id="modal-content">';
                              $modal_code += $modal_content.html();
                              $modal_code += '</div>';
                              $modal_content.empty();
                              }
                           }
                  $modal_code += '</div></div>';

                  $( $modal_code ).insertBefore($('.overlay-classic'));

                  // if some ui component must be initialized
                  // Do stuff...

                  $body.addClass('no-scroll');
                  $('html').addClass('active-overlay-classic');

                  event.preventDefault();

            });

            // add overlay
            if ($('.overlay-classic').length < 1) {
                $modal_overlay = '<span id="modal-overlay" class="overlay overlay-classic" title="Fermer la fenÃªtre" data-background-click="enabled"><span class="u-hiddenVisually">Fermer la fenÃªtre</span></span>';
            }
            else { $modal_overlay = '<span id="modal-overlay" class="overlay overlay-classic" data-background-click="disabled"></span>'; }

            $('body').append( $modal_overlay );

            $('#modal-close').focus();

            // close button and esc key
            $body.on( 'click', '#modal-close', function( event ) {
                  var $this = $(this),
                      $focus_back = '#' + $this.attr('data-focus-back'),
                      $content_back_id = $this.attr('data-content-back-id'),
                      $js_modal = $('#modal'),
                      $js_modal_content = $('#modal-content'),
                      $class_element = $js_modal.attr('class'),
                      $class_element_reverse = $class_element + '--reverse',
                      $js_modal_overlay = $('.overlay-classic');

                  var delay = $js_modal.css( "animation-duration" );
                  //alert(delay);
                  if ( delay != '0s' ){
                      var timeout = parseFloat(delay.replace('s','')) * 1000;
                      timeout++;

                      $js_modal.removeClass( $class_element );
                      setTimeout(function() { $js_modal.addClass( $class_element_reverse ); }, 1);
                      setTimeout(function() {
                           $body.removeClass('no-scroll');
                           $('html').removeClass('active-overlay-classic');
                           $js_modal.remove();
                           if ($content_back_id !== ''){
                              $('#' + $content_back_id).html( $js_modal_content.html() ); 
                              }
                           $( $focus_back ).focus();
                           $js_modal.removeClass( $class_element_reverse );
                           $js_modal.addClass( $class_element );
                         }, timeout);
                     }
                     else {
                           $body.removeClass('no-scroll');
                           $('html').removeClass('active-overlay-classic');
                           $js_modal.remove();
                           if ($content_back_id !== ''){
                              $('#' + $content_back_id).html( $js_modal_content.html() );
                              }
                           $( $focus_back ).focus();
                          }

            })
            .on( app.clickEvent, '.overlay-classic', function( event ) {
                  var $close = $('#modal-close');

                  event.preventDefault();
                  $close.trigger('click');

            })
            .on( 'keydown', '.overlay-classic', function( event ) {
                   var $close = $('#modal-close');

                   if ( event.keyCode == 13 || event.keyCode == 32 ) { // space or enter
                       event.preventDefault();
                       $close.trigger('click');
                       }
            })
            .on( "keydown", "#modal", function( event ) {
                  var $this = $(this),
                      $close = $('#modal-close');

                  if ( event.keyCode == 27 ) { // esc
                      $close.trigger('click');
                     }
                  if ( event.keyCode == 9 ) { // tab or maj+tab

                     // get list of all children elements in given object
                     var children = $this.find('*');

                     // get list of focusable items
                     var focusableItems = children.filter(focusableElementsString).filter(':visible');

                     // get currently focused item
                     var focusedItem = $( document.activeElement );

                     // get the number of focusable items
                     var numberOfFocusableItems = focusableItems.length;

                     var focusedItemIndex = focusableItems.index(focusedItem);

                     if ( !event.shiftKey && (focusedItemIndex == numberOfFocusableItems - 1) ){
                         focusableItems.get(0).focus();
                         event.preventDefault();
                        }
                     if ( event.shiftKey && focusedItemIndex === 0 ){
                         focusableItems.get(numberOfFocusableItems - 1).focus();
                         event.preventDefault();
                        }


                     }

            })
            .on( "keyup", ":not(#modal)", function( event ) {
                   var $this = $(this),
                       $js_modal = $('#modal'),
                       focusedItem = $( document.activeElement ),
                       in_jsmodal = focusedItem.parents('#modal').length ? true : false;
                       $close = $('#modal-close');

                   if ( $js_modal.length && event.keyCode == 9 && in_jsmodal === false ) { // tab or maj+tab
                      $close.focus();
                   }

            })
            .on( 'focus', '#modal-tabindex', function( event ) {
                  $close.focus(); 
            });

        } // end if

    }, // end init
        
};

$(document).ready(function(){
    app.modalController.defaultAction.init();
});
