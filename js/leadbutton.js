(function() {
    tinymce.create('tinymce.plugins.lead', {
        init : function(ed, url) {
            ed.addButton('lead', {
                title : 'Lead Button',
                image : url+'/lead.png',
                onclick : function() {
                     ed.selection.setContent('[lead]' + ed.selection.getContent() + '[/lead]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('lead', tinymce.plugins.lead);
})();