<?php

add_shortcode('list_sites', 'mism_list_sites');

function mism_list_sites($atts)
{
    $atts = shortcode_atts(
            array(
                'type' => 'active',
                'title' => '',
            ), $atts, 'list_sites' );
    
    $html = '';
    
    if($atts['type']=="active")
    {
        
        //$blogs = get_blogs_of_user(get_current_user_id(),false);
        $blogs = OrderMap::getUserBlogsDetailed(get_current_user_id());
       $html .= '<div class="tng-responsive-table">';
        
        if(count($blogs)>0)
        {
			$html .= '<table>';
            $html .= '<h3>'.$atts['title'].'</h3>';
            
            $html .= '<thead class="site-list-container">';
                $html .= '<th class="numeric">'.__('Sr. No.','mism').'</th>';
                $html .= '<th class="numeric">'.__('Site Name','mism').'</th>';
                $html .= '<th class="numeric">'.__('Site URL','mism').'</th>';
                $html .= '<th class="numeric">'.__('Action','mism').'</th>';
            $html .= '</thead>';
            
            $html .= '<tbody>';
                $active_count = 1;
                foreach($blogs AS $blog)
                {
                    $externalDomain = getExternalDomainByBlogId($blog->userblog_id);
                    $html .= '<tr>';
                    $html .= '<td data-title="Sr. No." class="srno">'.$active_count.'</td>';
                    $html .= '<td data-title="Site Name">'.$blog->blogname.'</td>';
                    $html .= '<td data-title="Site URL">';
                    $html .= '<ol>';
                    $html .= '<li><a href="'.$blog->siteurl.'" title="'.$blog->blogname.'" target="_blank">'.$blog->siteurl.'</a></li>';
                    if(isset($externalDomain) && $externalDomain!="")
                    {
                        $html .= '<li><a href="http://'.$externalDomain.'" title="'.$blog->blogname.'" target="_blank">http://'.$externalDomain.'</a></li>';
                    }
                    $html .= '</td>';
                    $html .= '<td data-title="Action">';
                    if (0 != $blog->deleted) {
                        $html .= 'This site is no longer available.<br/>After moderation it will be dropped.';
                    } else {
                        // $html .= '<input class="listblog_edit" type="submit" name="edit_site" value="Edit"/>';
                        $html .= '<input data-id="' . $blog->userblog_id . '" class="listblog_delete button" data-sending-label="Deleting..." type="submit" name="delete_site" value="Delete"/>';
                        $html .= '<input id="listblog_id" type="hidden" name="blog_id" value="' . $blog->userblog_id . '"/>';
                    }
                    $html .= '</td>';
                    $html .= '</tr>';
                    $active_count++;
                }
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
            $html .= '</div>';
           
           
		 }
		 else
        {
			$html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
			$html .= '<div class="avia_message_box_content">';
			$html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
			$html .= '<p>'.__('No Active Sites found.','mism').'</p>';
			$html .= ' </div>';
			$html .= '	</div>';
        }
    }
  
    elseif($atts['type']=="all")
    {
        //$blogs = get_blogs_of_user(get_current_user_id(),false);
        $blogs = OrderMap::getUserBlogsDetailed(get_current_user_id());
        
        if(count($blogs)>0)
        {
			$html .= '<table class="blog-list-container '.$atts['type'].'">';
            $html .= '<h3>'.$atts['title'].'</h3>';
            
            $html .= '<thead class="blog-list-title">';
                $html .= '<th>'.__('Sr. No.','mism').'</th>';
                $html .= '<th>'.__('Site Name','mism').'</th>';
                $html .= '<th>'.__('Site URL','mism').'</th>';
                $html .= '<th>'.__('Link','mism').'</th>';
            $html .= '</thead>';
            
            $html .= '<tbody>';
                $active_count = 1;
                foreach($blogs AS $blog)
                {
                    if($blog==0)
                    {
                        $html .= '<tr>';
                        $html .= '<td>'.$active_count.'</td>';
                        $html .= '<td>'.$blog->blogname.'</td>';
                        $html .= '<td>'.$blog->siteurl.'</td>';
                        $html .= '<td>'.'<a href="'.$blog->siteurl.'" target="_blank">'.__('Visit Site','mism').'</a>'.'</td>';
                        $html .= '</tr>';
                        $active_count++;
                    }
                }
            $html .= '</tbody>';
             $html .= '</table>'; 
        }
       
        else
        {
            $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
			$html .= '<div class="avia_message_box_content">';
			$html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
			$html .= '<p>'.__('No Active Sites found.','mism').'</p>';
			$html .= ' </div>';
			$html .= '	</div>';
        }
    }
    elseif($atts['type']=="delete")
    {
        //$blogs = get_blogs_of_user(get_current_user_id(),false);
        $blogs = OrderMap::getUserBlogsDetailed(get_current_user_id());
        
        
        if(count($blogs)>0)
        {
			$html .= '<table class="blog-list-container '.$atts['type'].'">';
            $html .= '<h3>'.$atts['title'].'</h3>';
            
            $html .= '<thead class="blog-list-title">';
                $html .= '<th>'.__('Sr. No.','mism').'</th>';
                $html .= '<th>'.__('Site Name','mism').'</th>';
                $html .= '<th>'.__('Site URL','mism').'</th>';
                $html .= '<th>'.__('Link','mism').'</th>';
            $html .= '</thead>';
            
            $html .= '<tbody>';
                $active_count = 1;
                foreach($blogs AS $blog)
                {

                    $html .= '<tr>';
                    $html .= '<td>'.$active_count.'</td>';
                    $html .= '<td>'.$blog->blogname.'</td>';
                    $html .= '<td>'.$blog->siteurl.'</td>';
                    $html .= '<td>'.'<a href="'.$blog->siteurl.'" target="_blank">'.__('Visit Site','mism').'</a>'.'</td>';
                    $html .= '</tr>';
                    $active_count++;
                }
            $html .= '</tbody>';
           $html .= '</table>'; 
        }
         
        else
        {
           $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
			$html .= '<div class="avia_message_box_content">';
			$html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
			$html .= '<p>'.__('No Active Sites found.','mism').'</p>';
			$html .= ' </div>';
			$html .= '	</div>';
        }
    }
    
    return $html;
}


?>
