function EnviraGalleryImagesUpdate(e){EnviraGalleryImages.reset();var a="ul#envira-gallery-output li.envira-gallery-image"+(e?".selected":"");jQuery(a).each(function(){var e=jQuery.parseJSON(jQuery(this).attr("data-envira-gallery-image-model"));e.alt=EnviraGalleryStripslashes(e.alt),EnviraGalleryImages.add(new EnviraGalleryImage(e))}),jQuery("#envira-gallery-main span.count").text(jQuery("ul#envira-gallery-output li.envira-gallery-image").length)}function EnviraGalleryStripslashes(e){return(e+"").replace(/\\(.?)/g,function(e,a){switch(a){case"\\":return"\\";case"0":return"\0";case"":return"";default:return a}})}function envira_gallery_sortable($){$(envira_gallery_output).sortable({containment:envira_gallery_output,items:"li",cursor:"move",forcePlaceholderSize:!0,placeholder:"dropzone",helper:function(e,a){a.hasClass("selected")||a.addClass("selected").siblings().removeClass("selected");var t=a.parent().children(".selected").clone();a.data("multidrag",t).siblings(".selected").remove();var i=$("<li/>");return i.append(t)},stop:function(e,a){var t=a.item.data("multidrag");a.item.after(t).remove(),$("li.selected",$(envira_gallery_output)).removeClass("selected"),$.ajax({url:envira_gallery_metabox.ajax,type:"post",async:!0,cache:!1,dataType:"json",data:{action:"envira_gallery_sort_images",order:$(envira_gallery_output).sortable("toArray").toString(),post_id:envira_gallery_metabox.id,nonce:envira_gallery_metabox.sort},success:function(e){EnviraGalleryImagesUpdate(!1)},error:function(e,a,t){$(envira_gallery_output).before('<div class="error"><p>'+a.responseText+"</p></div>")}})}})}jQuery(document).ready(function($){$('select[name="_envira_gallery[image_size]"]').on("change",function(){"envira_gallery_random"==$(this).val()?$("tr#envira-config-image-sizes-random-box").show():$("tr#envira-config-image-sizes-random-box").hide()}),$('select[name="_envira_gallery[image_size]"]').trigger("change")}),function($){$(function(){var e=!1;"default"==$('input[name="_envira_gallery[type]"]:checked').val()?$("#envira-gallery-preview").hide():$("#envira-gallery-preview").show(),$(document).on("enviraGalleryType enviraGalleryPreview",function(){var a=$('input[name="_envira_gallery[type]"]:checked').val(),t=$("#envira-gallery-preview .spinner"),i=$("#envira-gallery-preview-main");return"default"==a?void $(i).hide():void(e||(e=!0,$(i).html(""),$.ajax({type:"post",url:envira_gallery_metabox.ajax,dataType:"json",data:{action:"envira_gallery_change_preview",post_id:envira_gallery_metabox.id,type:a,data:$("form#post").serializeArray(),nonce:envira_gallery_metabox.preview_nonce},success:function(a){$(i).html(a),$(t).hide(),e=!1},error:function(a,n){$(i).html('<div class="error"><p>'+a.responseText+"</p></div>"),$(t).hide(),e=!1}})))})})}(jQuery),function($){$(function(){$("#envira-gallery-types-nav").on("click","li",function(e){$('input[name="_envira_gallery[type]"]',$(this)).prop("checked",!0).trigger("change")}),$(document).on("change",'input[name="_envira_gallery[type]"]:radio',function(e){var a=$(this).val(),t=$("#envira-tabs #envira-tab-images .spinner"),i=$("#envira-tabs #envira-tab-images #envira-gallery-main");$(t).css("visibility","visible"),$("li",$(this).closest("#envira-gallery-types-nav")).removeClass("envira-active"),$(this).closest("li").addClass("envira-active"),$("a",$("#envira-tabs-nav li").first()).trigger("click"),$(i).html(""),$.ajax({type:"post",url:envira_gallery_metabox.ajax,dataType:"json",data:{action:"envira_gallery_change_type",post_id:envira_gallery_metabox.id,type:a,nonce:envira_gallery_metabox.change_nonce},success:function(e){$(i).html(e.html),$(document).trigger("enviraGalleryType",e),$(t).hide()},error:function(e,a){$(i).html('<div class="error"><p>'+e.responseText+"</p></div>"),$(t).hide()}})})})}(jQuery);var envira_video_link="p.envira-intro a.envira-video",envira_close_video_link="a.envira-video-close";jQuery(document).ready(function($){$(document).on("click",envira_video_link,function(e){e.preventDefault();var a=$(this).attr("href");a.search("autoplay=1")==-1&&(a+=a.search("rel=")==-1?"?rel=0&autoplay=1":"&autoplay=1"),$("div.envira-video-help").remove();var t=$(this).closest("p.envira-intro");$(t).append('<div class="envira-video-help"><iframe src="'+a+'" /><a href="#" class="envira-video-close dashicons dashicons-no"></a></div>')}),$(document).on("click",envira_close_video_link,function(e){e.preventDefault(),$(this).closest(".envira-video-help").remove()})});var EnviraGalleryBulkEditImageView=wp.Backbone.View.extend({tagName:"li",className:"attachment",template:wp.template("envira-meta-bulk-editor-image"),initialize:function(e){this.model=e.model},render:function(){return this.$el.html(this.template(this.model.attributes)),this}}),EnviraGalleryBulkEditView=wp.Backbone.View.extend({tagName:"div",className:"edit-attachment-frame mode-select hide-menu hide-router",template:wp.template("envira-meta-bulk-editor"),events:{"keyup input":"updateItem","keyup textarea":"updateItem","change input":"updateItem","change textarea":"updateItem","blur textarea":"updateItem","change select":"updateItem","click .actions a.envira-gallery-meta-submit":"saveItem","keyup input#link-search":"searchLinks","click div.query-results li":"insertLink","click button.media-file":"insertMediaFileLink","click button.attachment-page":"insertAttachmentPageLink"},initialize:function(e){this.on("loading",this.loading,this),this.on("loaded",this.loaded,this),this.is_loading=!1,this.collection=e.collection,this.child_views=e.child_views,this.model=new EnviraGalleryImage},render:function(){return this.$el.html(this.template(this.model.toJSON())),this.collection.forEach(function(e){var a=new EnviraGalleryBulkEditImageView({model:e});this.$el.find("ul.attachments").append(a.render().el)},this),this.child_views.length>0&&this.child_views.forEach(function(e){var a=new e({model:this.model});this.$el.find("div.addons").append(a.render().el)},this),setTimeout(function(){quicktags({id:"caption",buttons:"strong,em,link,ul,ol,li,close"}),QTags._buttonsInit()},500),wpLink.init,this},renderError:function(e){var a={};a.error=e;var t=new wp.media.view.EnviraGalleryError({model:a});return t.render().el},loading:function(){this.is_loading=!0,this.$el.find(".spinner").css("visibility","visible")},loaded:function(e){this.is_loading=!1,this.$el.find(".spinner").css("visibility","hidden"),"undefined"!=typeof e&&this.$el.find("ul.attachments").before(this.renderError(e))},updateItem:function(e){""!=e.target.name&&("checkbox"==e.target.type?value=e.target.checked?1:0:value=e.target.value,this.model.set(e.target.name,value))},saveItem:function(e){e.preventDefault(),this.trigger("loading");var a=[];this.collection.forEach(function(e){a.push(e.id)},this),wp.media.ajax("envira_gallery_save_bulk_meta",{context:this,data:{nonce:envira_gallery_metabox.save_nonce,post_id:envira_gallery_metabox.id,meta:this.model.attributes,image_ids:a},success:function(e){this.collection.forEach(function(e){for(var a in this.model.attributes)value=this.model.attributes[a],value.length>0&&e.set(a,value);var t=JSON.stringify(e.attributes);jQuery("ul#envira-gallery-output li#"+e.get("id")).attr("data-envira-gallery-image-model",t),jQuery("ul#envira-gallery-output li#"+e.get("id")+" div.title").text(e.get("title"))},this),jQuery("nav.envira-tab-options input[type=checkbox]").prop("checked",!1).trigger("change"),this.trigger("loaded loaded:success"),EnviraGalleryModalWindow.close()},error:function(e){this.trigger("loaded loaded:error",e)}})},insertMediaFileLink:function(e){this.trigger("loading"),this.model.set("link",response.media_link),this.trigger("loaded loaded:success"),this.render()},insertAttachmentPageLink:function(e){this.trigger("loading"),this.model.set("link",response.media_link),this.trigger("loaded loaded:success"),this.render()}});jQuery(document).ready(function($){$("#envira-gallery-main").on("click","a.envira-gallery-images-edit",function(e){e.preventDefault(),EnviraGalleryImagesUpdate(!0),EnviraGalleryModalWindow.content(new EnviraGalleryBulkEditView({collection:EnviraGalleryImages,child_views:EnviraGalleryChildViews})),EnviraGalleryModalWindow.open()})}),jQuery(document).ready(function($){$(document).on("click","a.envira-gallery-images-delete",function(e){e.preventDefault();var a=confirm(envira_gallery_metabox.remove_multiple);if(!a)return!1;var t=[];$("ul#envira-gallery-output > li.selected").each(function(){t.push($(this).attr("id"))});var i=$(this).parent().attr("id");$.ajax({url:envira_gallery_metabox.ajax,type:"post",dataType:"json",data:{action:"envira_gallery_remove_images",attachment_ids:t,post_id:envira_gallery_metabox.id,nonce:envira_gallery_metabox.remove_nonce},success:function(e){$("ul#envira-gallery-output > li.selected").remove(),$("nav.envira-select-options").fadeOut(),$(".envira-gallery-load-library").attr("data-envira-gallery-offset",0).addClass("has-search").trigger("click"),EnviraGalleryImagesUpdate(!1)},error:function(e,a,t){$(envira_gallery_output).before('<div class="error"><p>'+a.responseText+"</p></div>")}})}),$(document).on("click","#envira-gallery-main .envira-gallery-remove-image",function(e){e.preventDefault();var a=confirm(envira_gallery_metabox.remove);if(a){var t=$(this).parent().attr("id");$.ajax({url:envira_gallery_metabox.ajax,type:"post",dataType:"json",data:{action:"envira_gallery_remove_image",attachment_id:t,post_id:envira_gallery_metabox.id,nonce:envira_gallery_metabox.remove_nonce},success:function(e){$("#"+t).fadeOut("normal",function(){$(this).remove(),$(".envira-gallery-load-library").attr("data-envira-gallery-offset",0).addClass("has-search").trigger("click"),EnviraGalleryImagesUpdate(!1)})},error:function(e,a,t){$(envira_gallery_output).before('<div class="error"><p>'+a.responseText+"</p></div>")}})}})});var EnviraGalleryImage=Backbone.Model.extend({defaults:{id:"",title:"",caption:"",alt:"",link:""}}),EnviraGalleryImages=new Backbone.Collection;if("undefined"==typeof EnviraGalleryModalWindow)var EnviraGalleryModalWindow=new wp.media.view.Modal({controller:{trigger:function(){}}});var EnviraGalleryEditView=wp.Backbone.View.extend({tagName:"div",className:"edit-attachment-frame mode-select hide-menu hide-router",template:wp.template("envira-meta-editor"),events:{"click .edit-media-header .left":"loadPreviousItem","click .edit-media-header .right":"loadNextItem","keyup input":"updateItem","keyup textarea":"updateItem","change input":"updateItem","change textarea":"updateItem","blur textarea":"updateItem","change select":"updateItem","click .actions a.envira-gallery-meta-submit":"saveItem","keyup input#link-search":"searchLinks","click div.query-results li":"insertLink","click button.media-file":"insertMediaFileLink","click button.attachment-page":"insertAttachmentPageLink"},initialize:function(e){this.on("loading",this.loading,this),this.on("loaded",this.loaded,this),this.is_loading=!1,this.collection=e.collection,this.child_views=e.child_views,this.attachment_id=e.attachment_id,this.attachment_index=0,this.search_timer="";var a=0;this.collection.each(function(e){return e.get("id")==this.attachment_id?(this.model=e,this.attachment_index=a,!1):void a++},this)},render:function(){return this.$el.html(this.template(this.model.attributes)),this.child_views.length>0&&this.child_views.forEach(function(e){var a=new e({model:this.model});this.$el.find("div.addons").append(a.render().el)},this),this.$el.find("textarea[name=caption]").val(this.model.get("caption")),setTimeout(function(){quicktags({id:"caption",buttons:"strong,em,link,ul,ol,li,close"}),QTags._buttonsInit()},500),wpLink.init,0==this.attachment_index&&this.$el.find("button.left").addClass("disabled"),this.attachment_index==this.collection.length-1&&this.$el.find("button.right").addClass("disabled"),this},renderError:function(e){var a={};a.error=e;var t=new wp.media.view.EnviraGalleryError({model:a});return t.render().el},loading:function(){this.is_loading=!0,this.$el.find(".spinner").css("visibility","visible")},loaded:function(e){this.is_loading=!1,this.$el.find(".spinner").css("visibility","hidden"),"undefined"!=typeof e&&this.$el.find("div.media-toolbar").after(this.renderError(e))},loadPreviousItem:function(){this.attachment_index--,this.model=this.collection.at(this.attachment_index),this.attachment_id=this.model.get("id"),this.render()},loadNextItem:function(){this.attachment_index++,this.model=this.collection.at(this.attachment_index),this.attachment_id=this.model.get("id"),this.render()},updateItem:function(e){""!=e.target.name&&("checkbox"==e.target.type?value=e.target.checked?e.target.value:0:value=e.target.value,this.model.set(e.target.name,value))},saveItem:function(e){e.preventDefault(),this.trigger("loading"),wp.media.ajax("envira_gallery_save_meta",{context:this,data:{nonce:envira_gallery_metabox.save_nonce,post_id:envira_gallery_metabox.id,attach_id:this.model.get("id"),meta:this.model.attributes},success:function(e){this.trigger("loaded loaded:success");var a=JSON.stringify(this.model.attributes),t=jQuery("ul#envira-gallery-output li#"+this.model.get("id"));jQuery(t).attr("data-envira-gallery-image-model",a),jQuery("div.meta div.title span",t).text(this.model.get("title")),jQuery("div.meta div.title a.hint",t).attr("title",this.model.get("title")),this.model.get("title").length>20?jQuery("div.meta div.title a.hint",t).removeClass("hidden"):jQuery("div.meta div.title a.hint",t).addClass("hidden");var i=this.$el.find(".saved");i.fadeIn(),setTimeout(function(){i.fadeOut()},1500)},error:function(e){this.trigger("loaded loaded:error",e)}})},searchLinks:function(e){},insertLink:function(e){},insertMediaFileLink:function(e){this.trigger("loading"),wp.media.ajax("envira_gallery_get_attachment_links",{context:this,data:{nonce:envira_gallery_metabox.save_nonce,attachment_id:this.model.get("id")},success:function(e){this.model.set("link",e.media_link),this.trigger("loaded loaded:success"),this.render()},error:function(e){this.trigger("loaded loaded:error",e)}})},insertAttachmentPageLink:function(e){this.trigger("loading"),wp.media.ajax("envira_gallery_get_attachment_links",{context:this,data:{nonce:envira_gallery_metabox.save_nonce,attachment_id:this.model.get("id")},success:function(e){this.model.set("link",e.attachment_page),this.trigger("loaded loaded:success"),this.render()},error:function(e){this.trigger("loaded loaded:error",e)}})}}),EnviraGalleryChildViews=[];jQuery(document).ready(function($){$(document).on("click","#envira-gallery-main a.envira-gallery-modify-image",function(e){e.preventDefault(),EnviraGalleryImagesUpdate(!1);var a=$(this).parent().data("envira-gallery-image");EnviraGalleryModalWindow.content(new EnviraGalleryEditView({collection:EnviraGalleryImages,child_views:EnviraGalleryChildViews,attachment_id:a})),EnviraGalleryModalWindow.open()})}),jQuery(document).ready(function($){$("a.envira-media-library").on("click",function(e){return e.preventDefault(),wp.media.frames.envira?void wp.media.frames.envira.open():(wp.media.frames.envira=wp.media({frame:"post",title:wp.media.view.l10n.insertIntoPost,button:{text:wp.media.view.l10n.insertIntoPost},multiple:!0}),wp.media.frames.envira.on("open",function(){var e=wp.media.frames.envira.state().get("selection");$("ul#envira-gallery-output li").each(function(){var a=wp.media.attachment($(this).attr("id"));e.add(a?[a]:[])})}),wp.media.frames.envira.on("insert",function(e){var a=wp.media.frames.envira.state(),t=[];e.each(function(e){var i=a.display(e).toJSON();switch(i.link){case"none":e.set("link",e.get("url"));break;case"file":e.set("link",e.get("url"));break;case"post":break;case"custom":e.set("link",i.linkUrl)}t.push(e.toJSON())},this),$.post(envira_gallery_metabox.ajax,{action:"envira_gallery_insert_images",nonce:envira_gallery_metabox.insert_nonce,post_id:envira_gallery_metabox.id,images:t},function(e){e&&e.success&&($("#envira-gallery-output").html(e.success),EnviraGalleryImagesUpdate(!1))},"json")}),void wp.media.frames.envira.open())})});var envira_gallery_output="#envira-gallery-output",envira_gallery_shift_key_pressed=!1,envira_gallery_last_selected_image=!1;jQuery(document).ready(function($){$(document).on("click","nav.envira-tab-options a",function(e){e.preventDefault();var a=$(this).closest(".envira-tab-options"),t=$(this).data("view"),i=$(this).data("view-style");$(t).hasClass(i)||($(t).removeClass("list").removeClass("grid").addClass(i),$("a",a).removeClass("selected"),$(this).addClass("selected"),$.ajax({url:envira_gallery_metabox.ajax,type:"post",dataType:"json",data:{action:"envira_gallery_set_user_setting",name:"envira_gallery_image_view",value:i,nonce:envira_gallery_metabox.set_user_setting_nonce},success:function(e){},error:function(e,a,t){$(envira_gallery_output).before('<div class="error"><p>'+a.responseText+"</p></div>")}}))}),$(document).on("change","nav.envira-tab-options input",function(e){$(this).prop("checked")?($("li",$(envira_gallery_output)).addClass("selected"),$("nav.envira-select-options").fadeIn()):($("li",$(envira_gallery_output)).removeClass("selected"),$("nav.envira-select-options").fadeOut())}),envira_gallery_sortable($),$(document).on("enviraGalleryType",function(){$(envira_gallery_output).length>0&&envira_gallery_sortable($)}),$(document).on("click","ul#envira-gallery-output li.envira-gallery-image > img, li.envira-gallery-image > div, li.envira-gallery-image > a.check",function(e){e.preventDefault();var a=$(this).parent();if($(a).hasClass("selected"))$(a).removeClass("selected"),envira_gallery_last_selected_image=!1;else{if(envira_gallery_shift_key_pressed&&envira_gallery_last_selected_image!==!1){var t=$("ul#envira-gallery-output li").index($(envira_gallery_last_selected_image)),i=$("ul#envira-gallery-output li").index($(a)),n=0;if(t<i)for(n=t;n<=i;n++)$("ul#envira-gallery-output li:eq( "+n+")").addClass("selected");else for(n=i;n<=t;n++)$("ul#envira-gallery-output li:eq( "+n+")").addClass("selected")}$(a).addClass("selected"),envira_gallery_last_selected_image=$(a)}$("ul#envira-gallery-output > li.selected").length>0?$("nav.envira-select-options").fadeIn():$("nav.envira-select-options").fadeOut()}),$(document).on("keyup keydown",function(e){envira_gallery_shift_key_pressed=e.shiftKey})}),jQuery(document).ready(function($){$("#envira-gallery-main").on("click","a.envira-gallery-images-move",function(e){e.preventDefault();var a=$(this).data("action");EnviraGalleryModalWindow.content(new EnviraGallerySelectionView({action:a,multiple:!1,sidebar_view:"envira-meta-move-media-sidebar",modal_title:envira_gallery_metabox.move_media_modal_title,insert_button_label:envira_gallery_metabox.move_media_insert_button_label,onInsert:function(){EnviraGalleryImagesUpdate(!0);var e=[];EnviraGalleryImages.forEach(function(a){e.push(a.get("id"))}),this.selection.forEach(function(t){wp.media.ajax("envira_"+a+"_move_media",{context:this,data:{nonce:envira_gallery_metabox.move_media_nonce,from_gallery_id:envira_gallery_metabox.id,to_gallery_id:t.id,image_ids:e},success:function(e){$("ul#envira-gallery-output > li.selected").remove(),$("nav.envira-select-options").fadeOut(),EnviraGalleryImagesUpdate(!1),EnviraGalleryModalWindow.close()},error:function(e){alert(e)}})})}})),EnviraGalleryModalWindow.open()})}),function($){$(function(){if("undefined"!=typeof uploader){$("input#plupload-browse-button").val(envira_gallery_metabox.uploader_files_computer);var e=$("#envira-gallery .envira-progress-bar"),a=$("#envira-gallery .envira-progress-bar div.envira-progress-bar-inner"),t=$("#envira-gallery .envira-progress-bar div.envira-progress-bar-status"),i=$("#envira-gallery-output"),n=$("#envira-gallery-upload-error"),r=0;uploader.bind("Init",function(e){$("#drag-drop-area").fadeIn(),$("a.envira-media-library.button").fadeIn()}),uploader.bind("FilesAdded",function(a,i){$(n).html(""),r=i.length,$(".uploading .current",$(t)).text("1"),$(".uploading .total",$(t)).text(r),$(".uploading",$(t)).show(),$(".done",$(t)).hide(),$(e).fadeIn()}),uploader.bind("UploadProgress",function(e,i){$(".uploading .current",$(t)).text(r-e.total.queued+1),$(a).css({width:e.total.percent+"%"})}),uploader.bind("FileUploaded",function(e,a,t){$.post(envira_gallery_metabox.ajax,{action:"envira_gallery_load_image",nonce:envira_gallery_metabox.load_image,id:t.response,post_id:envira_gallery_metabox.id},function(e){switch(envira_gallery_metabox.media_position){case"before":$(i).prepend(e);break;case"after":default:$(i).append(e)}EnviraGalleryImagesUpdate(!1)},"json")}),uploader.bind("UploadComplete",function(){$(".uploading",$(t)).hide(),$(".done",$(t)).show(),setTimeout(function(){$(e).fadeOut()},1e3)}),uploader.bind("Error",function(e,a){$("#envira-gallery-upload-error").html('<div class="error fade"><p>'+a.file.name+": "+a.message+"</p></div>"),e.refresh()})}})}(jQuery);