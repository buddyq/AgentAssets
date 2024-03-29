<?php

add_shortcode('list_sites', 'mism_list_sites');

function mism_list_sites($atts)
{
  global $wpdb;
    $atts = shortcode_atts(
            array(
                'type' => 'active',
                'title' => '',
            ), $atts, 'list_sites' );

    $user_id = get_current_user_id();
    $html = '';
    if (!$user_id) {
        $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
        $html .= '<div class="avia_message_box_content">';
        $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
        $html .= '<p>'.__('Please login to access your sites list.','mism').'</p>';
        $html .= ' </div>';
        $html .= '	</div>';;
        return $html;
    }

    if($atts['type']=="active")
    {

        //$blogs = get_blogs_of_user(get_current_user_id(),false);
        $blogs = OrderMap::getUserBlogsDetailed($user_id);
        $html .= '<div class="tng-responsive-table">';

        if(count($blogs)>0)
        {
            $duration = 0;
            $order = OrderModel::findOne('`user_id` = %d AND `status` = %d AND `expiry_date` >= %s',
                array(get_current_user_id(), OrderModel::STATUS_PAID, date('Y-m-d H:i:s')));
            if ($order) {
                switch_to_blog(1);
                $duration = get_post_meta($order->package_id, 'wpcf-duration', true);
                restore_current_blog();
                $counter_details = PackageCounter::getCounterDetailsByOrderId($order->id);
                $html .= MedmaHelper::getConsumedSitesMessageBox($counter_details);
            }

			$html .= '<table>';
            $html .= '<h3>'.$atts['title'].'</h3>';

            $html .= '<thead class="site-list-container">';
              $html .= '<th class="numeric">'.__('No.','mism').'</th>';
              $html .= '<th class="numeric">'.__('Site Name','mism').'</th>';
              $html .= '<th class="numeric">'.__('Site URL','mism').'</th>';
              $html .= '<th class="numeric">'.__('Days Left','mism').'</th>';
              $html .= '<th class="numeric">'.__('Actions','mism').'</th>';
            $html .= '</thead>';

            $html .= '<tbody>';
                $active_count = 1;
                foreach($blogs AS $blog)
                {
                    $externalDomain = getExternalDomainByBlogId($blog->userblog_id);
                    $html .= '<tr>';
                    $html .= '<td data-title="No." class="srno">'.$active_count.'</td>';
                    $html .= '<td data-title="Site Name">'.$blog->blogname.'</td>';
                    $html .= '<td data-title="Site URL">';
                    $html .= '<ol>';
                    $html .= '<li><a href="'.$blog->siteurl.'" title="'.$blog->blogname.'" target="_blank">'.$blog->siteurl.'</a></li>';
                    if(isset($externalDomain) && $externalDomain!="")
                    {
                        $html .= '<li><a href="http://'.$externalDomain.'" title="'.$blog->blogname.'" target="_blank">http://'.$externalDomain.'</a></li>';
                    }
                    $html .= '</ol>';
                    $html .= '</td>';
                    $html .= '<td data-title="Days Left" class="days-left">'.$blog->days_left.'</td>';
                    $html .= '<td data-title="Actions" class="actions">';
                    
                    // Buddy
                    $html .= "Session: ".$_SESSION['site_deleted'] ."<br>";
                    foreach ($blog as $key => $value) {
                      $html .= 'Key: ' . $key . "   |   Value: " . $value . '<br>';
                    }
                    // Decide which button to show user
                    if (0 != $blog->deleted && $blog->days_left <= 0) {
                      $html .= '<div class="avia_message_box avia-color-red avia-size-normal avia-icon_select-no avia-border-dashed avia-builder-el-12 avia-builder-el-no-sibling "><div class="avia_message_box_content">';
                      $html .= '<p>This Site has Expired!</p><br>';
                      $sites_remaining = PackageCounter::getRemainingSites();
                      
                      if ($sites_remaining > 0) {
                        $html .= '<p><input data-site-name="' . $blog->blogname . '" data-id="' . $blog->userblog_id . '" class="listblog_extend button" data-sending-label="Restoring..." type="submit" name="restore_site" value="Restore"/></p>';
                      }else{
                        $html .= '<p><input data-site-name="' . $blog->blogname . '" data-id="' . $blog->userblog_id . '" class="restore_with_purchase button" data-sending-label="Restoring..." type="submit" name="restore_with_purchase" value="Restore"/></p>';
                      }
                      
                      $html .= '</div></div>';
                      $html .= '<p style="text-align:center">You have ' . (($sites_remaining > 1) ? $sites_remaining . ' sites' : $sites_remaining) . ' site' . ' remaining</p>';

                    }
                    elseif (0 != $blog->deleted) {
                        $date = getNextRemovingSitesTime('dS');
                        $tDay = getNextRemovingSitesTime('l');
                        $tMoYr = getNextRemovingSitesTime('F Y');
                        $time = getNextRemovingSitesTime('g:i a');
                        $html .= 'This site was deleted. You can restore it <br/>before '.$tDay['string']. ' the '.$date['string'].' of '. $tMoYr['string'] .' at '.$time['string'].'<br/> before it is removed completely.<br/>';
                        $html .= '<input data-site-name="' . $blog->blogname . '" data-id="' . $blog->userblog_id . '" class="listblog_restore button" data-sending-label="Restoring..." type="submit" name="restore_site" value="Restore"/>';
                    } else {
                        // $html .= '<input class="listblog_edit" type="submit" name="edit_site" value="Edit"/>';
                        $html .= '<input data-site-name="' . $blog->blogname . '" data-id="' . $blog->userblog_id . '" class="listblog_delete button" data-sending-label="Deleting..." type="submit" name="delete_site" value="Delete"/>';
                        $html .= '&nbsp;<a class="btn btn-primary button" href="'.$blog->siteurl.'/wp-admin/admin.php?page=mi-sub-agent-information">Edit</a>';
                        if ($blog->days_left < 7) {
                            if ($duration) {
                                $html .= '&nbsp;<input data-duration="' . $duration . '" data-site-name="' . $blog->blogname . '" data-id="' . $blog->userblog_id . '" class="listblog_extend button" data-sending-label="Extending..." type="submit" name="extend_site" value="Extend"/>';
                            } else {
                                // $html .= '&nbsp;<input data-site-name="' . $blog->blogname . '" class="listblog_pricing button" type="button" value="Extend j"/>';
                                $html .= '<p><input data-site-name="' . $blog->blogname . '" data-id="' . $blog->userblog_id . '" class="restore_with_purchase button" data-sending-label="Restoring..." type="submit" name="restore_with_purchase" value="Restore"/></p>';
                            }
                        }
                        //$html .= '<input id="listblog_id" type="hidden" name="blog_id" value="' . $blog->userblog_id . '"/>';
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
                $html .= '<th>'.__('No.','mism').'</th>';
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
