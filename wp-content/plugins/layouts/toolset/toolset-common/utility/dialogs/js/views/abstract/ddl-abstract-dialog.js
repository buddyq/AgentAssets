var DDLayout = DDLayout || {};

( function($) {
    $.widget('DDLayout.ddldialog', $.ui.dialog, {
        open: function() {
            // Add beforeOpen event.
            if ( this.isOpen() || false === this._trigger('beforeOpen') ) {
                return;
            }

            // Open the dialog.
            this._super();
            // WebKit leaves focus in the TinyMCE editor unless we shift focus.
            this.element.focus();
            this._trigger('refresh');
        },
        _allowInteraction: function( event ) {
<<<<<<< HEAD
            return !!$( event.target ).is( ".toolset_select2-input" ) || this._super( event );
=======
            return !!$( event.target ).is( ".select2-input" ) || this._super( event );
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
        },
        _create:function( ){
            this._super("_create");

            this.element.bind('ddldialogbeforeopen', function(event){
                //console.log('ddldialogbeforeopen', event)
            })
        },
        close:function(event){
            this._super('close');
        }
    });

    $.DDLayout.ddldialog.prototype.options.closeOnEscape = false;

})(jQuery);