var EnviraDropboxImporter=wp.media.view.MediaFrame.Post;wp.media.view.MediaFrame.Post=EnviraDropboxImporter.extend({addon_slug:"envira-dropbox-importer",addon_action_base:"envira_dropbox_importer",initialize:function(){EnviraDropboxImporter.prototype.initialize.apply(this,arguments),this.states.add([new wp.media.controller.EnviraGalleryController({id:this.addon_slug,content:this.addon_slug+"-content",toolbar:this.addon_slug+"-toolbar",menu:"default",title:"Dropbox",priority:200,type:"link",insert_action:this.addon_action_base+"_insert_images"})]),this.on("content:render:"+this.addon_slug+"-content",this.renderContent,this),this.on("toolbar:create:"+this.addon_slug+"-toolbar",this.renderToolbar,this)},renderContent:function(){this.content.set(new wp.media.view.EnviraGalleryView({controller:this,model:this.state().props,sidebar_template:this.addon_slug+"-side-bar",get_action:this.addon_action_base+"_get_files_folders",search_action:this.addon_action_base+"_search_files_folders",insert_action:this.addon_action_base+"_insert_images",path:"/"}))},renderToolbar:function(t){t.view=new wp.media.view.Toolbar.EnviraGalleryToolbar({controller:this})}});