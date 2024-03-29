<?php 
  $aveone_css_data = '';
  $template_url = get_template_directory_uri();

  $model = ThemeSettingsModel::model();

  $aveone_pagination_type = aveone_get_option('evl_pagination_type','pagination');
  $aveone_layout = aveone_get_option('evl_layout','2cl');
  $aveone_width_layout = aveone_get_option('evl_width_layout','fixed');
  $aveone_content_back = $model->content_color; //aveone_get_option('evl_content_back','light');
  $aveone_menu_back_color = $model->custom_menu_color; //aveone_get_option('evl_menu_back_color','');
  $aveone_menu_back = $model->menu_color; //aveone_get_option('evl_menu_back','light');
  $aveone_custom_main_color = $model->header_footer_color; //aveone_get_option('evl_header_footer_back_color','');
  $aveone_main_pattern = aveone_get_option('evl_pattern','pattern_8.png'); //todo
  $aveone_scheme_widgets = aveone_get_option('evl_scheme_widgets','#595959');
  $aveone_post_layout = aveone_get_option('evl_post_layout','two');
  $aveone_pos_logo = aveone_get_option('evl_pos_logo','left');
  $aveone_pos_button = aveone_get_option('evl_pos_button','right');
  $aveone_custom_background = /*$model->page_background_image; */ aveone_get_option('evl_custom_background','1');
  $aveone_tagline_pos = aveone_get_option('evl_tagline_pos','next');    
  $aveone_widget_background = aveone_get_option('evl_widget_background','0');
  $aveone_widget_background_image = aveone_get_option('evl_widget_background_image','0');
  $aveone_menu_background = $model->disable_menu_background; //aveone_get_option('evl_disable_menu_back','0');
  $aveone_social_color = aveone_get_option('evl_social_color_scheme','#999999');
  $aveone_social_icons_size = aveone_get_option('evl_social_icons_size','normal');
  $aveone_button_color_1 = $model->buttons_1_color; //aveone_get_option('evl_button_1','');
  $aveone_button_color_2 = $model->buttons_2_color; //aveone_get_option('evl_button_2','');
  $aveone_scheme_background = $model->page_background_image; //aveone_get_option('evl_scheme_background', '');
  $aveone_scheme_background_color = aveone_get_option('evl_scheme_background_color', '');
  $aveone_scheme_background_100 = $model->page_100_background_image; //aveone_get_option('evl_scheme_background_100', '0');
  $aveone_scheme_background_repeat = $model->page_background_repeat; //aveone_get_option('evl_scheme_background_repeat', 'repeat');
  $aveone_general_link = aveone_get_option('evl_general_link', '#7a9cad');
  $aveone_animatecss = aveone_get_option('evl_animatecss', '1');  
  $aveone_gmap_address = aveone_get_option('evl_gmap_address', '');
  $aveone_status_gmap = aveone_get_option('evl_status_gmap', '');
  $aveone_gmap_width = aveone_get_option('evl_gmap_width', '100%');
  $aveone_gmap_height = aveone_get_option('evl_gmap_height', '415px');
  $aveone_width_px = aveone_get_option('evl_width_px', '1200');
  $aveone_content_box1_icon_color = aveone_get_option('evl_content_box1_icon_color', '#faa982');  
  $aveone_content_box2_icon_color = aveone_get_option('evl_content_box2_icon_color', '#8fb859');
  $aveone_content_box3_icon_color = aveone_get_option('evl_content_box3_icon_color', '#78665e');    
  $aveone_content_box4_icon_color = aveone_get_option('evl_content_box4_icon_color', '#82a4fa');  
  $aveone_min_width_px = $aveone_width_px + 20;
  
$aveone_css_data .= 'body {background-color:#000000;}';  

if(aveone_get_option('evl_main_menu_hover_effect','0')==1) {
                          
$aveone_css_data .= '.link-effect a span {-webkit-transition: none;-moz-transition: none;transition: none;} 
.link-effect a span::before {-webkit-transform: none;-moz-transform: none;transform: none;font-weight:normal;}';

}
  
  if($aveone_width_px && ($aveone_width_layout == "fixed")) { 
  $aveone_css_data .= ' 
  @media (min-width: '.$aveone_min_width_px.'px) {
  .container, #wrapper {
    width: 960px!important;
  }
}';
} else {
 $aveone_css_data .= ' 
  @media (min-width: '.$aveone_min_width_px.'px) {
  .container {
    width: 960px!important;
  }  
  .menu-back .container {
    width: 100%!important;padding-left:0px!important;padding-right:0px!important;
  }
}'; 
}  

$aveone_css_data .= '';

  
if($aveone_gmap_address && $aveone_status_gmap):
 $aveone_css_data .= '#gmap, #map-canvas{width:'.$aveone_gmap_width.';margin:0 auto;';
	if($aveone_gmap_height):
	$aveone_css_data .= 'height:'.$aveone_gmap_height.' !important';
	else:
	$aveone_css_data .= 'height:415px !important;';
	endif;
  $aveone_css_data .= '}';    
	endif;
 
 
if ($aveone_animatecss == "1") { 
 $aveone_css_data .= ' 
 @media only screen and (min-width: 768px){
 .link-effect a:hover span,
.link-effect a:focus span {
	-webkit-transform: translateY(-100%);
	-moz-transform: translateY(-100%);
	transform: translateY(-100%); 
} }

.entry-content .thumbnail-post:hover img {
   -webkit-transform: scale(1.1,1.1);
   -moz-transform: scale(1.1,1.1);
   -o-transform: scale(1.1,1.1);
   -ms-transform: scale(1.1,1.1);
   transform: scale(1.1,1.1);
}
.entry-content .thumbnail-post:hover .mask {
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";
   filter: alpha(opacity=100);
   opacity: 1;
}
.entry-content .thumbnail-post:hover div.icon {
   -ms-filter: "progid: DXImageTransform.Microsoft.Alpha(Opacity=100)";
   filter: alpha(opacity=100);
   opacity: 1;
   top:50%;
   margin-top:-21px;
   -webkit-transition-delay: 0.1s;
   -moz-transition-delay: 0.1s;
   -o-transition-delay: 0.1s;
   -ms-transition-delay: 0.1s;
   transition-delay: 0.1s;
}


';
}
 if ($aveone_layout == "2cr") { 
  
  $aveone_css_data .= '/**
 * 2 column (aside)(content) fixed layout
 */

 @media (min-width: 768px) {
#primary {float:right;}  
     }

';
   
  } if ($aveone_layout == "3cr") { 
  
 $aveone_css_data .= '/**
 * 3 column (aside)(aside)(content) fixed layout
 */

 #secondary, #secondary-2 { float: left; }
 #primary {float:right;}

';
  
  
 } if ($aveone_layout == "3cl") { 
 
 $aveone_css_data .= '/**
 * 3 column (aside)(aside)(content) fixed layout
 */      

 #secondary, #secondary-2 { float: right; }

'; 
  
  
} if ($aveone_layout == "3cm") { 

 $aveone_css_data .= '/**
 *  3 columns (aside)(content)(aside) fixed layout
 */    
#secondary { float: right; }
#secondary-2 { float: left; } 
';
  
  
} if ($aveone_width_layout == "fluid") { 

 $aveone_css_data .= '/**
 * Basic 1 column (content)(aside) fluid layout
 * 
 * @package WPAveone
 * @subpackage Layouts
 * @beta
 */


#wrapper {margin:0;width:100%;}

'
;
 
  
} if ($aveone_layout == "1c") { 
 
 $aveone_css_data .= '/**
 * 1 column (content) fixed layout
 * 
 * @package WPAveone
 * @subpackage Layouts
 * @beta
 */

'; 

} if ($aveone_content_back == "dark") { 
 
 
 $aveone_css_data .= '/**
 * Dark content
 * 
 */

body {color:#ddd;}

.entry-title, .entry-title a {color:#ccc;text-shadow:0 1px 0px #000;}
.entry-title, .entry-title a:hover { color: #fff; }

input[type="text"], input[type="password"],input[type="email"], textarea {border:1px solid #CCC!important;}


#search-text-top {border-color: rgba(0, 0, 0, 0)!important;}

.entry-content img, .entry-content .wp-caption {background:transparent;border: 1px solid #404040;}

#slide_holder, .similar-posts {background:rgba(0, 0, 0, 0.2);}

#slide_holder .featured-title a, #slide_holder .twitter-title {color:#ddd;}
#slide_holder .featured-title a:hover {color:#fff;}
#slide_holder .featured-title, #slide_holder .twitter-title, #slide_holder p {text-shadow:0 1px 1px #333;}

#slide_holder .featured-thumbnail {background:#444;border-color:#404040;}   

var, kbd, samp, code, pre {background-color:#505050;}
pre {border-color:#444;}

.post-more, .anythingSlider .arrow span {border-color: #222; border-bottom-color: #111;text-shadow: 0 1px 0 #111;
   color: #aaa;
    background: #505050;               
    background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #505050),color-stop(1, #404040));
    background: -moz-linear-gradient(center top,#505050 20%,#404040 100%);
    background: -o-linear-gradient(top, #505050,#404040) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#505050\', endColorstr=\'#404040\');
    -webkit-box-shadow:  0 1px 0 rgba(255, 255, 255, 0.3) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow:   0 1px 0 rgba(255, 255, 255, 0.3) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow:   0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
}
a.post-more:hover, .anythingSlider .arrow a:hover span {color:#fff;}
  

.social-title, #reply-title {color:#fff;text-shadow:0 1px 0px #222;}
#social {-webkit-box-shadow:none!important;-moz-box-shadow:none!important;-box-shadow:none!important;box-shadow:none!important;}

.menu-back {border-top-color:#515151;}

.page-title {text-shadow:0 1px 0px #111;}


.hentry .entry-header .comment-count a { background:none !important;-moz-box-shadow:none !important;}

.content-bottom {background:#353535;border-color:#303030; }

.entry-header a {color:#eee;}

.entry-meta {text-shadow:0 1px 0 #111;}

.edit-post a {-moz-box-shadow:0 0 2px #333;color:#333;text-shadow:0 1px 0 #fff;}

.entry-footer a:hover {color:#fff;}

.widget-content {  
  background: #484848;
    border-color: #404040;
    box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;
    -box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
     -moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.1) inset;
    color: #FFFFFF;
}

.tab-holder .tabs li a {background:rgba(0, 0, 0, 0.05);}
.tab-holder .tabs li:last-child a {border-right: 1px solid #404040 !important;}
.tab-holder .tabs li a, .tab-holder .news-list li {-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}
.tab-holder .tabs li.active a {background:#484848;border-color: #404040 rgba(0, 0, 0, 0) #484848 #404040 !important;color: #eee !important;}
.tab-holder .tabs-container {background:#484848;border: 1px solid #404040 !important;border-top:0!important;}
.tab-holder .news-list li .post-holder a {color: #eee !important;}
.tab-holder .news-list li:nth-child(2n) {background: rgba(0, 0, 0, 0.05);}
.tab-holder .news-list li {border-bottom: 1px solid #414141;}
.tab-holder .news-list img {background: #393939;border: 1px solid #333;}

.author.vcard .avatar {border-color:#222;}  

.tipsy-inner {-moz-box-shadow:0 0 2px #111;}

#secondary a, #secondary-2 a, .widget-title  {text-shadow:1px 1px 0px #000; }
#secondary a, #secondary-2 a {color: #eee;} 

h1, h2, h3, h4, h5, h6 {color: #eee;}

ul.breadcrumbs {background:#484848;border: 1px solid #404040;-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}

ul.breadcrumbs li {color: #aaa;}
ul.breadcrumbs li a {color: #eee;}
ul.breadcrumbs li:after {color: rgba(255,255, 255, 0.2);}

.menu-container, .content, #wrapper {background:#555;}  

.widgets-back h3 {color:#fff !important;text-shadow:1px 1px 0px #000 !important;}
.widgets-back ul, .widgets-back ul ul, .widgets-back ul ul ul {list-style-image:url('.$template_url.'/library/media/images/dark/list-style-dark.gif) !important;}  

.widgets-back a:hover {color:orange}

.widgets-holder a {
    text-shadow: 0 1px 0 #000 !important;
}

#search-text, #search-text-top:focus, #respond input#author, #respond input#url, #respond input#email, #respond textarea {-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.2);}

.widgets-back .widget-title a {color:#fff !important;text-shadow:0 1px 3px #444 !important;}

.comment, .trackback, .pingback {text-shadow:0 1px 0 #000;background: #505050; border-color: #484848;}
.comment-header {background:#484848;border-bottom: 1px solid #484848;box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}

.avatar {  background:#444444;border-color: #404040;}

#leave-a-reply {text-shadow:0 1px 1px #333333;}

.entry-content .read-more a, #page-links a {border-color: #222; border-bottom-color: #111;text-shadow: 0 1px 0 #111;
    color: #aaa;
    background: #505050;               
    background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #505050),color-stop(1, #404040));
    background: -moz-linear-gradient(center top,#505050 20%,#404040 100%);
    background: -o-linear-gradient(top, #505050,#404040);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#505050\', endColorstr=\'#404040\');
    -webkit-box-shadow:  1px 1px 0 rgba(255, 255, 255, 0.1) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    -moz-box-shadow:  1px 1px 0 rgba(255, 255, 255, 0.1) inset,0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
    box-shadow:   1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);}

.share-this a { text-shadow:0 1px 0px #111; }
.share-this a:hover {color:#fff;}
.share-this strong {color:#999;border:1px solid #222;text-shadow:0 1px 0px #222;background:#505050;
background:-moz-linear-gradient(center top , #505050 20%, #404040 100%) repeat scroll 0 0 transparent;
   background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #505050),color-stop(1, #404040)) !important;
    background: -o-linear-gradient(top, #505050,#404040) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#505050\', endColorstr=\'#404040\');
-webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
-moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
box-shadow: 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
}

.entry-content .read-more {text-shadow: 0 1px 0 #111111;}
.entry-header .comment-count a {color:#aaa;}

a.comment-reply-link {background:#484848;border: 1px solid #404040;
box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-moz-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-webkit-box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);}
    
.share-this:hover strong {color:#fff;}

.page-navigation .nav-next, .single-page-navigation .nav-next, .page-navigation .nav-previous, .single-page-navigation .nav-previous {color:#777;}
.page-navigation .nav-previous a, .single-page-navigation .nav-previous a, .page-navigation .nav-next a, .single-page-navigation .nav-next a {color:#999999;text-shadow:0 1px 0px #333;}
.page-navigation .nav-previous a:hover, .single-page-navigation .nav-previous a:hover, .page-navigation .nav-next a:hover, .single-page-navigation .nav-next a:hover {color:#eee;}
.icon-big:before {color:#666;}
.page-navigation .nav-next:hover a, .single-page-navigation .nav-next:hover a, .page-navigation .nav-previous:hover a, .single-page-navigation .nav-previous:hover a, .icon-big:hover:before, .btn:hover, .btn:focus {color:#fff;}

/* Page Navi */

.wp-pagenavi a, .wp-pagenavi span {-moz-box-shadow:0 1px 2px #333;background:#555;color:#999999;text-shadow:0 1px 0px #333;}
.wp-pagenavi a:hover, .wp-pagenavi span.current {background:#333;color:#eee;}


#page-links a:hover {background:#333;color:#eee;}

blockquote {color:#bbb;text-shadow:0 1px 0px #000;border-color:#606060;}
blockquote:before, blockquote:after {color: #606060;}

table {background:#505050;border-color: #494949;}
thead, thead th, thead td {background:rgba(0, 0, 0, 0.1);color:#FFFFFF;text-shadow:0 1px 0px #000;}
thead {box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.1) inset;}
th, td {border-bottom: 1px solid rgba(0, 0, 0, 0.1);border-top: 1px solid rgba(255, 255, 255, 0.02);}    

table#wp-calendar th, table#wp-calendar tbody tr td {color:#888;text-shadow:0 1px 0px #111;}
table#wp-calendar tbody tr td {border-right:1px solid #484848;border-top:1px solid #555;}
table#wp-calendar th {color:#fff;text-shadow:0 1px 0px #111;}
table#wp-calendar tbody tr td a {text-shadow:0 1px 0px #111;}
';




  } if ($aveone_menu_back == "dark") { 
  

$aveone_css_data .= 'ul.nav-menu a {color:#fff;text-shadow:0 1px 0px #333; }

ul.nav-menu li.nav-hover ul { background: #505050; }

ul.nav-menu ul li a {border-bottom-color:#484848;}

ul.nav-menu ul li:hover > a, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a  {border-top-color:#666!important;}

ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {border-top-color:#666; }

ul.nav-menu ul {border: 1px solid #444; border-bottom:0;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 2px rgba(255, 255, 255, 0.3) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1);
}

ul.nav-menu li {border-left-color: #444;border-right-color:  #666;}

.menu-header {background:#505050;
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -7px repeat-x, -moz-linear-gradient(center top , #606060 20%, #505050 100%);
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -7px repeat-x, -webkit-gradient(linear,left top,left bottom,color-stop(.2, #606060),color-stop(1, #505050)) !important;
    background: url('.$template_url.'/library/media/images/dark/trans.png) 0px -7px repeat-x,-o-linear-gradient(top, #606060,#505050) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#606060\', endColorstr=\'#505050\');
    -webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);
    color:#fff;text-shadow:0 1px 0px #000;
    border-color:#222;  
} 

body #header.sticky-header a.logo-url-text {color:#fff;}

ul.nav-menu ul { box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05) inset, 0 0 2px rgba(255, 255, 255, 0.05) inset, 0 0 10px rgba(0, 0, 0, 0.1) inset, 0 1px 2px rgba(0, 0, 0, 0.1)!important;
}

ul.nav-menu li.current-menu-item, ul.nav-menu li.current-menu-ancestor, ul.nav-menu li:hover {border-right-color:#666!important;}

ul.nav-menu > li.current-menu-item, ul.nav-menu > li.current-menu-ancestor, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a {background-color:rgba(0, 0, 0, 0.1)!important;}


body #header.sticky-header {background: rgba(80, 80, 80, 0.95) !important;border-bottom: 1px solid rgba(0, 0, 0, 0.5);}
#wrapper .dd-container .dd-selected-text {background: rgba(0, 0, 0, 0.5);box-shadow: 1px 1px 0 rgba(255, 255, 255, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.1);}
.dd-option {
    border-bottom: 1px solid #404040!important;          
    }
#wrapper .dd-options li { border-bottom: 1px solid #404040 !important; }     
   #wrapper .dd-options {background:#444!important;border-color:#404040!important;}
    #wrapper .dd-container label, #wrapper .dd-container a {color: #eee!important;}
#wrapper .dd-options li a:hover,#wrapper .dd-options li.dd-option-selected a{background-color:#333 !important;color:#fff !important;}

#search-text-top:focus {-webkit-box-shadow:1px 1px 0px rgba(0,0,0,.9);-moz-box-shadow:1px 1px 0px rgba(0,0,0,.9);-box-shadow:1px 1px 0px rgba(0,0,0,.9);box-shadow:1px 1px 0px rgba(0,0,0,.9);}
'; 
 
 if (!empty($aveone_menu_back_color)) {
 
 $aveone_menu_back_color = mb_substr($aveone_menu_back_color,1);  
 
 $aveone_css_data .= 'ul.nav-menu li.nav-hover ul { background: #'.$aveone_menu_back_color.'; }

ul.nav-menu ul li:hover > a, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a  {border-top-color:#'.$aveone_menu_back_color.'!important;}

ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {border-top-color:#'.$aveone_menu_back_color.'; }

ul.nav-menu ul {border: 1px solid #'.aveone_hexDarker($aveone_menu_back_color).'; border-bottom:0;}

ul.nav-menu ul li a {border-color: #'.aveone_hexDarker($aveone_menu_back_color).'!important;}

ul.nav-menu li {border-left-color: #'.aveone_hexDarker($aveone_menu_back_color).';border-right-color:  #'.$aveone_menu_back_color.';}

.menu-header {background:#'.$aveone_menu_back_color.';
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -10px repeat-x,-moz-linear-gradient(center top , #'.$aveone_menu_back_color.' 20%, #'.aveone_hexDarker($aveone_menu_back_color).' 100%);
   background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -10px repeat-x,-webkit-gradient(linear,left top,left bottom,color-stop(.2, #'.$aveone_menu_back_color.'),color-stop(1, #'.aveone_hexDarker($aveone_menu_back_color).')) !important;
    background:url('.$template_url.'/library/media/images/dark/trans.png) 0px -10px repeat-x,-o-linear-gradient(top, #'.$aveone_menu_back_color.',#'.aveone_hexDarker($aveone_menu_back_color).') !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#'.$aveone_menu_back_color.'\', endColorstr=\'#'.aveone_hexDarker($aveone_menu_back_color).'\');
    border-color:#'.aveone_hexDarker($aveone_menu_back_color).';  
} 

body #header.sticky-header {background:#'.$aveone_menu_back_color.'!important;
    border-bottom-color:#'.aveone_hexDarker($aveone_menu_back_color).';
}


ul.nav-menu li.current-menu-item, ul.nav-menu li.current-menu-ancestor, ul.nav-menu li:hover {border-right-color:#'.$aveone_menu_back_color.'!important;}';

   
} } else {


 if (!empty($aveone_menu_back_color)) {
 
 $aveone_menu_back_color = mb_substr($aveone_menu_back_color,1);  
 
 $aveone_css_data .= 'ul.nav-menu li.nav-hover ul { background: #'.$aveone_menu_back_color.'; }

ul.nav-menu ul li:hover > a, ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a  {border-top-color:#'.$aveone_menu_back_color.'!important;}

ul.nav-menu li.current-menu-ancestor li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor li.current-menu-parent > a {border-top-color:#'.$aveone_menu_back_color.'; }

ul.nav-menu ul {border: 1px solid '.aveone_hexDarker($aveone_menu_back_color).'; border-bottom:0;
   }

ul.nav-menu li {border-left-color: '.aveone_hexDarker($aveone_menu_back_color).';border-right-color:  #'.$aveone_menu_back_color.';}

.menu-header {background:#'.$aveone_menu_back_color.';
   background:url('.$template_url.'/library/media/images/trans.png) 0px -10px repeat-x,-moz-linear-gradient(center top , #'.$aveone_menu_back_color.' 20%, #'.aveone_hexDarker($aveone_menu_back_color).' 100%);
   background:url('.$template_url.'/library/media/images/trans.png) 0px -10px repeat-x,-webkit-gradient(linear,left top,left bottom,color-stop(.2, #'.$aveone_menu_back_color.'),color-stop(1, #'.aveone_hexDarker($aveone_menu_back_color).')) !important;
    background:url('.$template_url.'/library/media/images/trans.png) 0px -10px repeat-x,-o-linear-gradient(top, #'.$aveone_menu_back_color.',#'.aveone_hexDarker($aveone_menu_back_color).') !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#'.$aveone_menu_back_color.'\', endColorstr=\'#'.aveone_hexDarker($aveone_menu_back_color).'\');
    border-color:#'.aveone_hexDarker($aveone_menu_back_color).';  
} 
ul.nav-menu li.current-menu-item, ul.nav-menu li.current-menu-ancestor, ul.nav-menu li:hover {border-right-color:#'.$aveone_menu_back_color.'!important;}';   
}


     
 
} if (!empty($aveone_custom_main_color)) { 

$aveone_css_data .= '
.header, .footer {background:'.$aveone_custom_main_color.';}
';

} if ($aveone_main_pattern != "none" ) { 

$aveone_css_data .= '
.header, .footer {background-image:url('.$template_url.'/library/media/images/pattern/'.$aveone_main_pattern.');}
';


} if ($aveone_scheme_widgets != "" ) {


$aveone_scheme_color = mb_substr($aveone_scheme_widgets,1);          

$aveone_css_data .= '.menu-back {
 background-color:'.$aveone_scheme_widgets.'; 
 background: -webkit-gradient(radial, center center, 0, center center, 460, from('.$aveone_scheme_widgets.'), to(#'.aveone_hexDarker($aveone_scheme_color,40).'));  
 background: -webkit-radial-gradient(circle, '.$aveone_scheme_widgets.', #'.aveone_hexDarker($aveone_scheme_color,40).');  
 background: -moz-radial-gradient(circle, '.$aveone_scheme_widgets.', #'.aveone_hexDarker($aveone_scheme_color,40).');  
 background: -o-radial-gradient(circle, '.$aveone_scheme_widgets.', #'.aveone_hexDarker($aveone_scheme_color,40).');
 background: -ms-radial-gradient(circle, '.$aveone_scheme_widgets.', #'.aveone_hexDarker($aveone_scheme_color,40).');
}
.da-dots span {background:#'.aveone_hexDarker($aveone_scheme_color).'}
';
 } if ($aveone_post_layout == "two") { 
 
  if ($aveone_pagination_type == "infinite") {
	$clear = '';  
  }else{
	$clear = 'clear:both;';
  } 
  
  $aveone_css_data .= '/**
 * Posts Layout
 * 
 */   

   
.home .type-post .entry-content, .archive .type-post .entry-content, .search .type-post .entry-content, .page-template-blog-page-php .type-post .entry-content {font-size:13px;}
.entry-content {margin-top:25px;}
.home .odd0, .archive .odd0, .search .odd0, .page-template-blog-page-php .odd0 {'.$clear.'}
.home .odd1, .archive .odd1, .search .odd1, .page-template-blog-page-php .odd1{margin-right:0px;}
.home .entry-title, .entry-title a, .archive .entry-title, .search .entry-title, .page-template-blog-page-php .entry-title {font-size:120%!important;line-height:120%!important;margin-bottom:0;}
.home .entry-header, .archive .entry-header, .search .entry-header, .page-template-blog-page-php .entry-header {font-size:12px;padding:0;}
.home .published strong, .archive .published strong,  .search .published strong, .page-template-blog-page-php .published strong{font-size:15px;line-height:15px;}
.home .type-post .comment-count a, .archive .type-post .comment-count a, .search .type-post .comment-count a, .page-template-blog-page-php .type-post .comment-count a  {color:#bfbfbf;background:url('.$template_url.'/library/media/images/comment.png) 0 9px no-repeat;text-decoration:none;position:relative;bottom:-9px;border:none;padding:8px 10px 8px 18px;}
.home .hfeed, .archive .hfeed, .single .hfeed, .page .hfeed, .page-template-blog-page-php .hfeed {margin-right:0px;}
.home .type-post .entry-footer, .archive .type-post .entry-footer, .search .type-post .entry-footer, .page-template-blog-page-php .type-post .entry-footer {float:left;width:100%}
.home .type-post .comment-count, .archive .type-post .comment-count, .search .type-post .comment-count, .page-template-blog-page-php .type-post .comment-count {background:none!important;padding-right:0;}';
  
 } if ($aveone_post_layout == "three") {
	 
  if ($aveone_pagination_type == "infinite") {
	$clear = '';  
  }else{
	$clear = 'clear:both;';
  }	 
  
$aveone_css_data .= '/**
 * Posts Layout
 * 
 */       


.home .type-post .entry-content, .archive .type-post .entry-content, .search .type-post .entry-content, .page-template-blog-page-php .type-post .entry-content {font-size:13px;}
.entry-content {margin-top:25px;}
.home .odd0, .archive .odd0, .search .odd0, .page-template-blog-page-php .odd0 {'.$clear.'}
.home .odd2, .archive .odd2, .search .odd2, .page-template-blog-page-php .odd2 {margin-right:0px;}
.home .entry-title, .entry-title a, .archive .entry-title, .search .entry-title, .page-template-blog-page-php .entry-title {font-size:100%!important;line-height:100%!important;margin-bottom:0;}
.home .entry-header, .archive .entry-header, .search .entry-header, .page-template-blog-page-php .entry-header {font-size:12px;padding:0;}
.home .published strong, .archive .published strong, .search .published strong, .page-template-blog-page-php .published strong  {font-size:15px;line-height:15px;}
.home .type-post .comment-count a, .archive .type-post .comment-count a, .search .type-post .comment-count a, .page-template-blog-page-php .type-post .comment-count a   {color:#bfbfbf;background:url('.$template_url.'/library/media/images/comment.png) 0 9px no-repeat;text-decoration:none;position:relative;bottom:-9px;border:none;padding:8px 10px 8px 18px;}
.home .type-post .comment-count, .archive .type-post .comment-count, .search .type-post .comment-count, .page-template-blog-page-php .type-post .comment-count {background:none!important;padding-right:0;}';

} 

$blog_title = array(
    'style' => $model->big_title_font_style,
    'size' => $model->big_title_font_size . 'px',
    'face' => $model->big_title_font_face,
    'color' => $model->big_title_font_color,
); //aveone_get_option('evl_title_font');

if (!is_array($blog_title)){
  $blog_title= get_object_vars(json_decode($blog_title));
  //aveone_get_option('evl_title_font')=$blog_title;
}
//rm by ddo var_dump($blog_title);  
if ($blog_title) {

 $aveone_css_data .= '#logo, #logo a {font:' . $blog_title['style'] . ' '.$blog_title['size'] . ' ' . $blog_title['face']. '; color:'.$blog_title['color'].';letter-spacing:-.03em;}';
}

$blog_tagline = aveone_get_option('evl_tagline_font');
if (!is_array($blog_tagline)){
  $blog_tagline= get_object_vars(json_decode($blog_tagline));
  //aveone_get_option('evl_title_font')=$blog_title;
}

if ($blog_tagline) {
 $aveone_css_data .= '#tagline {font:' . $blog_tagline['style'] . ' '.$blog_tagline['size'] . ' ' . $blog_tagline['face']. '; color:'.$blog_tagline['color'].';}';
}

  if (($aveone_tagline_pos !== "disable") && ($aveone_tagline_pos == "under")) {
     $aveone_css_data .= '#tagline {clear:left;padding-top:10px;}';
     } 
     
     if (($aveone_tagline_pos !== "disable") && ($aveone_tagline_pos == "above")) { 
     $aveone_css_data .= '#tagline {padding-top:0px;}';
     }
    

$content_font = array(
    'style' => $model->content_font_style,
    'size' => $model->content_font_size . 'px',
    'face' => $model->content_font_face,
    'color' => $model->content_font_color,
); //aveone_get_option('evl_content_font');
if (!is_array($content_font)){
  $content_font= get_object_vars(json_decode($content_font));
  //aveone_get_option('evl_title_font')=$blog_title;
}
if ($content_font) {
 $aveone_css_data .= 'body, input, textarea, .entry-content {font-style:' . $content_font['style'] . '; font-size:' .$content_font['size'] . '!important; font-family:' . $content_font['face']. '; color:'.$content_font['color'].';line-height:1.5em;}
  body {color:'.$content_font['color'].'!important;}';
 
 }   
 
$heading_font = array(
    'style' => $model->headings_font_style,
    'size' => $model->headings_font_size . 'px',
    'face' => $model->headings_font_face,
    'color' => $model->headings_font_color,
); //aveone_get_option('evl_heading_font');
if (!is_array($heading_font)){
  $heading_font= get_object_vars(json_decode($heading_font));
  //aveone_get_option('evl_title_font')=$blog_title;
}
if ($heading_font) {
 $aveone_css_data .= 'h1, h2, h3, h4, h5, h6 {font-family:' . $heading_font['face']. '; color:'.$heading_font['color'].'} 
 #content h1, #content h2, #content h3, #content h4, #content h5, #content h6 { color:'.$heading_font['color'].'!important;}';
 }   
 
 $post_title = array(
     'style' => $model->post_title_font_style,
     'size' => $model->post_title_font_size . 'px',
     'face' => $model->post_title_font_face,
     'color' => $model->post_title_font_color,
 ); //aveone_get_option('evl_post_font');
if (!is_array($post_title)){
  $post_title= get_object_vars(json_decode($post_title));
  //aveone_get_option('evl_title_font')=$blog_title;
}
if ($post_title) {
 $aveone_css_data .= '.entry-title, .entry-title a, .page-title {font:' . $post_title['style'] . ' '.$post_title['size'] . ' ' . $post_title['face']. '; color:'.$post_title['color'].';}';
}     
 
$menu_font = array(
    'style' => $model->main_menu_font_style,
    'size' => $model->main_menu_font_size . 'px',
    'face' => $model->main_menu_font_face,
    'color' => $model->main_menu_font_color,
); //aveone_get_option('evl_menu_font');
if (!is_array($menu_font)){
  $menu_font= get_object_vars(json_decode($menu_font));
  //aveone_get_option('evl_title_font')=$blog_title;
}
//var_dump($menu_font);
if ($menu_font) {
 $aveone_css_data .= 'ul.nav-menu a {font:' . $menu_font['style'] . ' '.$menu_font['size'] . ' ' . $menu_font['face']. '; color:'.$menu_font['color'].';}';
 }   
 
$bootstrap_slide_title = aveone_get_option('evl_bootstrap_slide_title_font');
if ($bootstrap_slide_title) {
 $aveone_css_data .= '#bootstrap-slider .carousel-caption h2 {font:' . $bootstrap_slide_title['style'] . ' '.$bootstrap_slide_title['size'] . ' ' . $bootstrap_slide_title['face']. '!important; color:'.$bootstrap_slide_title['color'].';}';
} 

$bootstrap_slide_desc = aveone_get_option('evl_bootstrap_slide_desc_font');
if ($bootstrap_slide_desc) {
 $aveone_css_data .= '#bootstrap-slider .carousel-caption p {font:' . $bootstrap_slide_desc['style'] . ' '.$bootstrap_slide_desc['size'] . ' ' . $bootstrap_slide_desc['face']. '; color:'.$bootstrap_slide_desc['color'].';}';
}  
 
$parallax_slide_title = aveone_get_option('evl_parallax_slide_title_font');
if ($parallax_slide_title) {
 $aveone_css_data .= '.da-slide h2 {font:' . $parallax_slide_title['style'] . ' '.$parallax_slide_title['size'] . ' ' . $parallax_slide_title['face']. '!important; color:'.$parallax_slide_title['color'].';}';
} 

$parallax_slide_desc = aveone_get_option('evl_parallax_slide_desc_font');
if ($parallax_slide_desc) {
 $aveone_css_data .= '.da-slide p {font:' . $parallax_slide_desc['style'] . ' '.$parallax_slide_desc['size'] . ' ' . $parallax_slide_desc['face']. '; color:'.$parallax_slide_desc['color'].';}';
} 

$carousel_slide_title = aveone_get_option('evl_carousel_slide_title_font');
if ($carousel_slide_title) {
 $aveone_css_data .= '#slide_holder .featured-title a {font:' . $carousel_slide_title['style'] . ' '.$carousel_slide_title['size'] . ' ' . $carousel_slide_title['face']. '!important; color:'.$carousel_slide_title['color'].';}';
} 

$carousel_slide_desc = aveone_get_option('evl_carousel_slide_desc_font');
if ($carousel_slide_desc) {
 $aveone_css_data .= '#slide_holder p {font:' . $carousel_slide_desc['style'] . ' '.$carousel_slide_desc['size'] . ' ' . $carousel_slide_desc['face']. '; color:'.$carousel_slide_desc['color'].';}';
} 

if ($aveone_pos_logo == "center") { 
    $aveone_css_data .= '.header .container.container-header.custom-header #logo-image {float:none;margin:0 auto;}';
    $aveone_css_data .= '.container.container-header.custom-header {position:relative;}';
    $aveone_css_data .= '#righttopcolumn {position:absolute;right:0;top:0;}'; 
    $aveone_css_data .= '.title-container{display:table; margin:0 auto;text-align:center;}';
     
     if (($aveone_tagline_pos !== "disable") && ($aveone_tagline_pos == "next")) {
     $aveone_css_data .= '.title-container{display:flex;flex-flow:row wrap-reverse;justify-content:center;align-items:center;}';
     } 
} 
 
if ($aveone_pos_logo == "right") { 
 $aveone_css_data .= '#logo-image {float:right;margin:0 0 0 20px;}';
 } if ($aveone_pos_button == "left") { 
 $aveone_css_data .= '#backtotop {left:3%;margin-left:0;}';
 } if ($aveone_pos_button == "right") { 
 $aveone_css_data .= '#backtotop {right:3%;}';
 } if ($aveone_pos_button == "middle" || $aveone_pos_button == "") {
 $aveone_css_data .= '#backtotop {left:50%;}';

} if ($aveone_custom_background == "1") {

$aveone_css_data .= '#wrapper {position:relative;margin:0 auto 30px auto !important;background:#f9f9f9;box-shadow:0 0 3px rgba(0,0,0,.2);}

#wrapper:before {bottom: -34px;
    background: url('.$template_url.'/library/media/images/shadow.png) no-repeat scroll center top!important;
    left: 0px;
    position: absolute;
    z-index: -1;
    height: 7px;
    bottom: -7px;
    content: "";
    width: 100%;
}
';  

} if ($aveone_widget_background == "1") {

$aveone_css_data .= '#content h3.widget-title, h3.widget-title {color:#fff!important;text-shadow:1px 1px 0px #000;}
.widget-title-background {position:absolute;top:-1px;bottom:0px;left:-16px;right:-16px; 
-webkit-border-radius:3px 3px 0 0;-moz-border-radius:3px 3px 0 0;-border-radius:3px 3px 0 0;border-radius:3px 3px 0 0px;border:1px solid #222;
background:#505050;
background:-moz-linear-gradient(center top , #606060 20%, #505050 100%) repeat scroll 0 0 transparent;
   background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, #606060),color-stop(1, #505050)) !important;
    background: -o-linear-gradient(top, #606060,#505050) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#606060\', endColorstr=\'#505050\');
-webkit-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-moz-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);-box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);box-shadow: 0 1px 0 rgba(255, 255, 255, 0.3) inset, 0 0 5px rgba(0, 0, 0, 0.3) inset, 0 1px 2px rgba(0, 0, 0, 0.29);color:#fff;text-shadow:0 1px 0px #000;}';
}

 if ($aveone_widget_background_image == "1") {

$aveone_css_data .= '.widget-content {background: none!important;border: none!important;-webkit-box-shadow:none!important;-moz-box-shadow:none!important;-box-shadow:none!important;box-shadow:none!important;}
.widget:after, .widgets-holder .widget:after {content:none!important;}';

} 

 if ($aveone_menu_background == "1") {

$aveone_css_data .= '
.menu-header {filter:none;top:0;background: none!important;border: none!important;border-radius:0!important;-webkit-box-shadow:none!important;-moz-box-shadow:none!important;-box-shadow:none!important;box-shadow:none!important;}
.menu-header:before, .menu-header:after {content:none!important;}
ul.nav-menu li {border:none;}
ul.nav-menu li.current-menu-item > a, ul.nav-menu li.current-menu-ancestor > a, ul.nav-menu li a:hover,ul.nav-menu li:hover > a {
    background: none;box-shadow:none;}
ul.nav-menu li.current-menu-item > a:after, ul.nav-menu li.current-menu-ancestor > a:after {content:none;}    
    ';

} 

if ($aveone_layout == "2cr" && ($aveone_post_layout == "one") || $aveone_layout == "2cl" && ($aveone_post_layout == "one")) { 
$aveone_css_data .= '
.col-md-8 {padding-left:15px;padding-right:15px;}';
}   

if (!empty($aveone_general_link)) {     
$aveone_css_data .= '
a, .entry-content a:link, .entry-content a:active, .entry-content a:visited, #secondary a:hover, #secondary-2 a:hover {color:'.$aveone_general_link.';}';
}   


if (!empty($aveone_button_color_1)) {

$aveone_button_color_1_border = mb_substr($aveone_button_color_1,1);          
$aveone_css_data .= '
.entry-content .read-more a, a.comment-reply-link {background:'.$aveone_button_color_1.';border-color:#'.aveone_hexDarker($aveone_button_color_1_border).'}';
} 


if (!empty($aveone_button_color_2)) {

$aveone_button_color_2_border = mb_substr($aveone_button_color_2,1);          
$aveone_css_data .= '
a.more-link, input[type="submit"], button, .button, input#submit {background:'.$aveone_button_color_2.';border-color:#'.aveone_hexDarker($aveone_button_color_2_border).'}';
}    

if( get_header_image() ) {   
$aveone_css_data .= '.header {padding:0;} .custom-header {padding:40px 20px 5px 20px!important;width: 985px;min-height:125px;background:url('.get_header_image().') top center no-repeat;border-bottom:0;}';

if ($aveone_width_layout == "fluid") { 
$aveone_css_data .= '.header {padding:0;} .custom-header {padding:40px 20px 5px 20px!important;left:-20px;position:relative;min-height:125px;background:url('.get_header_image().') top center no-repeat;border-bottom:0;}';
} 
} 
  
if (!empty($aveone_social_color)) {
$aveone_css_data .= '#rss, #email-newsletter, #facebook, #twitter, #instagram, #skype, #youtube, #flickr, #linkedin, #plus, #pinterest { color: '.$aveone_social_color.';}';
} 

if (!empty($aveone_social_icons_size)) {
$aveone_css_data .= '#rss, #email-newsletter, #facebook, #twitter, #instagram, #skype, #youtube, #flickr, #linkedin, #plus, #pinterest { font-size: '.$aveone_social_icons_size.';}';
} 

/*/*if ($aveone_scheme_background) {
$aveone_css_data .= ''; 
}

if ($aveone_scheme_background_color) {
$aveone_css_data .= 'body { background-color: '.$aveone_scheme_background_color.'}'; 
}

if ($aveone_scheme_background_100 == '1') {
$aveone_css_data .= 'body { background-attachment:fixed;background-position:center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;}'; 
}

if ($aveone_scheme_background_repeat) {
$aveone_css_data .= 'body { background-repeat:'.$aveone_scheme_background_repeat.';}'; 
}

if ($aveone_content_box1_icon_color) {
$aveone_css_data .= '.content-box-1 i { color:'.$aveone_content_box1_icon_color.';}'; 
}
if ($aveone_content_box2_icon_color) {
$aveone_css_data .= '.content-box-2 i { color:'.$aveone_content_box2_icon_color.';}'; 
}
if ($aveone_content_box3_icon_color) {
$aveone_css_data .= '.content-box-3 i { color:'.$aveone_content_box3_icon_color.';}'; 
}
if ($aveone_content_box4_icon_color) {
$aveone_css_data .= '.content-box-4 i { color:'.$aveone_content_box4_icon_color.';}';	
}*/

$aveone_css_data .= '/* Extra small devices (phones, <768px) */
@media (max-width: 768px) { .da-slide h2, #bootstrap-slider .carousel-caption h2 {font-size:120%!important;letter-spacing:1px; }
#slide_holder .featured-title a {font-size:80%!important;letter-spacing:1px;} 
.da-slide p, #slide_holder p, #bootstrap-slider .carousel-caption p {font-size:90%!important; }
}

/* Small devices (tablets, 768px) */
@media (min-width: 768px) { .da-slide h2 {font-size:180%;letter-spacing:0; }
#slide_holder .featured-title a {font-size:120%;letter-spacing:0; }
.da-slide p, #slide_holder p {font-size:100%; }
}  

/* Large devices (large desktops) */
@media (min-width: 992px) { .da-slide h2 {font-size:'.$parallax_slide_title['size'].';line-height:1em; } 
#slide_holder .featured-title a {font-size:'.$carousel_slide_title['size'].';line-height:1em;}
.da-slide p {font-size:'.$parallax_slide_desc['size'].'; }
#slide_holder p {font-size:'.$carousel_slide_desc['size'].';} 
}';
 
$aveone_css_content = aveone_get_option('evl_css_content','');  
$aveone_css_data .= $aveone_css_content; 

if ( method_exists($wp_customize,'is_preview') and ! is_admin() ) {} else {
echo $aveone_css_data;
}

?>