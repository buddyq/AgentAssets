var DDLayout = DDLayout || {};

DDLayout.PanelDialog = function($, row_view)
{
    var self = this;

    self.row_view = row_view;

    _.extend( DDLayout.PanelDialog.prototype, new DDLayout.Dialogs.Prototype(jQuery) );

    self.init = function() {

        jQuery(document).on('click', '.js-panel-dialog-edit-save', {dialog: self}, function(event) {
            event.preventDefault();

	        var $css_input_id = jQuery( 'input.js-edit-css-id', jQuery(this).parent().parent()),
		        value = $css_input_id.val();

	        if( DDLayout.ddl_admin_page.htmlAttributesHandler.check_id_exists( $css_input_id, value ) )
	        {
                event.data.dialog._save( jQuery(this) );
	        }
        });

        jQuery(document).on('click', '#ddl-panel-edit .js-ddl-show', {dialog: self}, function(event) {
            event.preventDefault();
            jQuery('.js-front-end-options').show();
            jQuery('.js-ddl-show').hide();
            jQuery('.js-ddl-hide').show();

        });

        jQuery(document).on('click', '#ddl-panel-edit .js-ddl-hide', {dialog: self}, function(event) {
            event.preventDefault();
            jQuery('.js-front-end-options').hide();
            jQuery('.js-ddl-show').show();
            jQuery('.js-ddl-hide').hide();

        });

    };

    // TODO: ADD JS PREFIXES
    // TODO: Assign repetitive elements to variables. for example
    // var $layoutType = jQuery('#ddl-panel-edit #ddl-panel-edit-layout-type');
    self.show = function( mode, row_view ) {

        self.setCachedElement( row_view.model.toJSON() );

        var has_child_layout_alone = self.row_doesnt_render_in_front_end( row_view.model );

        if( has_child_layout_alone ){
            jQuery('.ddl-tab-right').hide();
        } else {
            jQuery('.ddl-tab-right').show();
        }

        jQuery('.js-edit-dialog-close').css('float', 'left')


		if (row_view.is_top_level_row() && has_child_layout_alone === false ) {

            jQuery('#js-row-not-render-message').hide();

            jQuery('.js-css-styling-controls').removeClass('from-top-0').show();
            jQuery('.ddl-dialog-content').removeClass('pad-top-0');

		} else if( row_view.is_top_level_row() && has_child_layout_alone ) {

            jQuery('#js-row-not-render-message').show();
            jQuery('.js-css-styling-controls').hide();
            jQuery('.ddl-dialog-content').removeClass('pad-top-0');
         
            jQuery('.js-row-dialog-edit-save').removeClass('button-primary').prop('disabled', true);
        } else {

            jQuery('#js-row-not-render-message').hide();

            jQuery('.ddl-dialog-content').addClass('pad-top-0');
            jQuery('.js-css-styling-controls').addClass('from-top-0').css('border-top', 0).show();
            
		}

        if (mode == 'edit') {
            jQuery('#ddl-panel-edit').data('mode', 'edit-row');
            jQuery('#ddl-panel-edit').data('row_view', row_view);

            jQuery('input[name="ddl-panel-edit-panel-name"]').val(row_view.model.get('name'));
<<<<<<< HEAD
	        jQuery('select.js-edit-css-class', jQuery('#ddl-panel-edit') ).val(row_view.model.get('additionalCssClasses'));
=======
	        jQuery('input.js-edit-css-class', jQuery('#ddl-panel-edit') ).val(row_view.model.get('additionalCssClasses'));
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
	        jQuery('input.js-edit-css-id', jQuery('#ddl-panel-edit') ).val( row_view.model.get('cssId') );
            jQuery('#ddl-panel-edit select[name="ddl_tag_name"]').val( row_view.model.get('tag') );


            jQuery('#ddl-panel-edit .js-dialog-edit-title').show();
            jQuery('#ddl-panel-edit .js-row-dialog-edit-save').show();

            jQuery('#ddl-panel-edit .js-dialog-add-title').hide();
            jQuery('#ddl-panel-edit .js-row-dialog-edit-add-row').hide();

	        jQuery('#ddl-panel-edit #ddl-panel-edit-layout-type').parent().hide();


        }

        jQuery.colorbox({
            href: '#ddl-panel-edit',
            closeButton:false,
            onComplete: function() {
                Toolset.hooks.doAction(self.row_view.model.get('kind') +'.dialog_open', self.row_view.model);
            },
            onCleanup:function(){
                jQuery('.js-css-styling-controls').removeClass('from-top-0').show();
                jQuery('.ddl-dialog-content').removeClass('pad-top-0');
                jQuery('.js-ddl-form-panel').removeClass('ddl-zero');
                jQuery('.js-row-dialog-edit-save').addClass('button-primary').prop('disabled', false);
                Toolset.hooks.doAction(self.row_view.model.get('kind') +'.dialog_close', self.row_view.model);
            }
        });
    };
    
    self._save = function (caller) {

        var target_row_view = jQuery('#ddl-panel-edit').data('row_view');

        if (jQuery('#ddl-panel-edit').data('mode') == 'add-row') {
            //

        } else if (jQuery('#ddl-panel-edit').data('mode') == 'edit-row') {


            DDLayout.ddl_admin_page.save_undo();

            var target_row = target_row_view.model;

            target_row.set('name', jQuery('input[name="ddl-panel-edit-panel-name"]').val() );
<<<<<<< HEAD
            target_row.set('additionalCssClasses', jQuery('select.js-edit-css-class', jQuery('#ddl-panel-edit') ).val() );
=======
            target_row.set('additionalCssClasses', jQuery('input.js-edit-css-class', jQuery('#ddl-panel-edit') ).val() );
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
            target_row.set('cssId', jQuery('input.js-edit-css-id', jQuery('#ddl-panel-edit') ).val() );
            target_row.set('tag', jQuery('#ddl-panel-edit select[name="ddl_tag_name"]').val() );
            
            DDLayout.ddl_admin_page.save_layout_from_dialog( caller, target_row_view, self.cached_element, false, self );
        }

        if( self.is_save_and_close(caller) ) jQuery.colorbox.close();

        return false;
    };

    
    self.init();
};