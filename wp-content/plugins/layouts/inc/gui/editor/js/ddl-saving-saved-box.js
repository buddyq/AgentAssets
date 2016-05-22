var DDLayout = DDLayout || {};

DDLayout.SavingSaved = function( $element ){
        var self = this
            , saved =  DDLayout_settings.DDL_JS.strings.all_changes_saved
            , saving =  DDLayout_settings.DDL_JS.strings.saving
            , $wrap = jQuery('<span class="all_changes_saved">')
            , $append = null;

    self.init = function( $element ){
        $append = $element;
    };

    self.show_saving = function( ){
        if( $append.find('.all_changes_saved').length ){
            jQuery('.all_changes_saved').remove();
        }
        $wrap.text( saving );
        $append.append( $wrap );
        $wrap.fadeIn(400, function(event){

        });
    };

    self.show_saved = function( ){
        if( $append.find('.all_changes_saved').length ){
            jQuery('.all_changes_saved').remove();
        }
        $wrap.text( saved );
        $append.append( $wrap );
        $wrap.fadeIn(400, function(event){

        });
    };

    self.swap_to_saving = function(){
        jQuery('.all_changes_saved').text( saving );
    };

    self.swap_to_saved = function(){
        jQuery('.all_changes_saved').text(saved);
    };

    self.remove = function(){
        jQuery('.all_changes_saved').remove();
    };

    self.init( $element );
};