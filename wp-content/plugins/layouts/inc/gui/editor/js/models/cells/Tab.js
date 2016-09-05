DDLayout.models.cells.Tab = DDLayout.models.cells.Row.extend({
    defaults: {
          kind: 'Tab'
        , cssClass: 'tab-pane'
        , row_type:'tabs-tab'
        , disabled: false
        , fade: false
        , mode: 'tab'
    },
    initialize:function(){
        var self = this;
        DDLayout.models.abstract.Element.prototype.initialize.call(self);
        self.set('cssClass', 'tab-pane');
    }
});