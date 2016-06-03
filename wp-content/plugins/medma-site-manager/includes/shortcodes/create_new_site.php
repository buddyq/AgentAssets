<?php
define('MISM_PRIMARY_SITE_ID', 1);
ob_start();
/* Create New Site | Shortcode */

add_shortcode('create_new_site', 'mism_create_new_site');

function mism_create_new_site($atts) {
    global $wpdb;
    
    $atts = shortcode_atts(
      array(
        'title' => '',
    ), $atts, 'create_new_site');

    #   User Package Authentication Check
    $current_date = date('Y-m-d H:i:s');
    $sql = "SELECT * FROM `" . $wpdb->base_prefix . "orders` WHERE `user_id`='" . get_current_user_id() . "' AND `status`='1' AND expiry_date>='" . $current_date . "'";
    $order_details = $wpdb->get_results($sql);
    // echo "<pre>"; print_r ($order_details); die("</pre>");
    
    $order_id = $order_details[0]->id;

    # Site Allowed Authentication
    $sql = "SELECT * FROM `" . $wpdb->base_prefix . "package_counter` WHERE `order_id`='" . $order_id . "'";
    $counter_details = $wpdb->get_results($sql);
    
    if (count($order_details) > 0) { # If Package Purchased, then continue
        $html = '';

        if (isset($_POST['submit'])) {
            $externalDomain = $_POST['domain'];
            $template_selected = $_POST['template'];
            $blogname = getSubdomainName($externalDomain);
            
            # Error Message if  improper domain name is passed by the user.
            $improper_domain = FALSE;
            if (empty($blogname)) {
                $improper_domain = TRUE;
            }

            # Patch | Local Sub Directory Version and LIVE Sub Domain Version compatibility change.
            if ($_SERVER['HTTP_HOST'] == "ahd.medma.tv" || $_SERVER['HTTP_HOST'] == "192.168.0.210") { # HTTP HOST for Local Development Server
                $domain = $_SERVER['HTTP_HOST'];
                $path = "/Tangerinefiles/" . $blogname;
            } else { # HTTP HOST automatically defined for LIVE server
                $domain = $blogname . "." . $_SERVER['HTTP_HOST'];
                $path = "/";
            }

            $siteTitle = $_POST['site_title'];
            $userID = $_POST['user_id'];

            # Package Authentication

            /* $sql = "SELECT * FROM `".$wpdb->base_prefix."orders` WHERE `user_id`='".$userID."' AND `status`='1'";
              $order_details = $wpdb->get_results($sql);
              if(count($order_details)>0) # If Package Purchased, then continue
              { */
            
            // echo "<pre>"; print_r ($counter_detail); die("</pre>");
            if ($counter_details[0]->site_allowed >= $counter_details[0]->site_consumed) { # Check for Package whether there is site available
                # Validate Blog SignUp Process
                if (wpmu_validate_blog_signup($blogname, $siteTitle, $userID)) {
                    global $wpdb;
                    # Register a Blog with the details provided.
                    $blog_id = wpmu_create_blog($domain, $path, $siteTitle, $userID);
                    //$blog_id = wpmu_create_blog($domain,$path, $siteTitle, $userID , array( 'public' => 1 ), $specified_blog_id );
                    $specified_blog_id = $template_selected;

                    # Check for Blog Existence, returns TRUE if exists
                    $blog_exists = FALSE;
                    if (!is_numeric($blog_id)) {
                        $blog_exists = TRUE;
                    }

                    if (is_numeric($blog_id)) {
                        # Process for cloning of primary blog created by admin to the new blog
                        mism_clone_blog($specified_blog_id, $blog_id);

                        # Process of copying files of primary blog created by admin to the new blog
                        MISM_Files::copy_files($specified_blog_id, $blog_id);
                    }
                    
                    if (is_numeric($blog_id)) {
                        $domain_map_insertion = $wpdb->insert($wpdb->base_prefix . 'domain_mapping', array(
                            'blog_id' => $blog_id,
                            'domain' => $externalDomain,
                            'active' => 1
                                ), array(
                            '%d',
                            '%s',
                            '%d'
                                )
                        );
                        
                        switch_to_blog(1); # Switch to Primary Blog

                        $ip = get_option('msm_main_site_ip');
                        if (empty($ip)) {
                            $ip = "";
                        }

                        $main_site_port = get_option('msm_main_site_port');
                        if (empty($main_site_port)) {
                            $main_site_port = "";
                        }

                        $main_site_output_type = get_option('msm_main_site_output_type');
                        if (empty($main_site_output_type)) {
                            $main_site_output_type = "";
                        }

                        $main_site_account = get_option('msm_main_site_account');
                        if (empty($main_site_account)) {
                            $main_site_account = "";
                        }

                        $main_site_cpanel_username = get_option('msm_main_site_cpanel_username');
                        if (empty($main_site_cpanel_username)) {
                            $main_site_cpanel_username = "";
                        }

                        $main_site_cpanel_password = get_option('msm_main_site_cpanel_password');
                        if (empty($main_site_cpanel_password)) {
                            $main_site_cpanel_password = "";
                        }
                       
                        # Connecting to cPanel API for communicating with Domain's parking
                        if (!empty($ip) && !empty($main_site_port) && !empty($main_site_output_type) && !empty($main_site_account) && !empty($main_site_cpanel_username) && !empty($main_site_cpanel_password)) 
                        {
                            $xmlapi = new xmlapi($ip);
                            
                            $xmlapi->set_port($main_site_port);
                            
                            $xmlapi->set_output($main_site_output_type);
                            
                            $account = $main_site_account;

                            # Authenticating with cPanel API using login credentials
                            $xmlapi->password_auth($main_site_cpanel_username, $main_site_cpanel_password);

                            $xmlapi->set_debug(1);
                            
                            $arg = array(
                                // 'dir' => 'public_html',
                                'domain' => $externalDomain,
                                'topdomain' => $blogname
                            );
                           
                           // echo "<pre>"; print_r ($xmlapi->password_auth); die("</pre>");
                            # Successful Domain Mapping
                            // $result = $xmlapi->api2_query($login, 'AddonDomain', 'addaddondomain', $arg);
                            
                            //Just need the username of the cpanel account here. Password is handled above in password auth
                            $result = $xmlapi->api2_query($main_site_cpanel_username, 'Park', 'park', $arg);
                           
                            restore_current_blog();
                            if ($result) {
                                # Update Package Status
                                $counter_consumed = ($counter_details[0]->site_consumed + 1);
                                $sql = "UPDATE `" . $wpdb->base_prefix . "package_counter` SET site_consumed='" . $counter_consumed . "' WHERE order_id='" . $order_id . "'";
                                $counter_id = $wpdb->query($sql);

                                OrderMap::addNewRelation($userID, $blog_id, $order_id);
                                ?>
                                <div class="avia_message_box avia-color-green avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-0  el_before_av_notification  avia-builder-el-first ">
                                    <span class="avia_message_box_title"><?php _e('Success', 'mism'); ?></span>
                                    <div class="avia_message_box_content">
                                      <span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>
                                      <p><?php _e('Site created successfully.', 'mism'); ?></p>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                  jQuery(function(){
                                          updateConsumed();
                                      });
                                </script>
                                <?php
                            } else {
                                $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                                $html .= '<span class="avia_message_box_title">Note</span>';
                                $html .= '<div class="avia_message_box_content">';
                                $html .= '<span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>';
                                $html .= '<p>Unable to map your domain with your microsite.</p>';
                                $html .= '</div>';
                                $html .= '<p>Please contact our support for more information or read our documentation.</p>';
                                $html .= '</div>';
                            }
                        } else {
                            
                            $counter_consumed = ($counter_details[0]->site_consumed + 1);
                            $sql = "UPDATE `" . $wpdb->base_prefix . "package_counter` SET site_consumed='" . $counter_consumed . "' WHERE order_id='" . $order_id . "'";
                            $counter_id = $wpdb->query($sql);

                            OrderMap::addNewRelation($userID, $blog_id, $order_id);
                            
                            $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                            $html .= '<span class="avia_message_box_title">Note</span>';
                            $html .= '<div class="avia_message_box_content">';
                            $html .= '<span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>';
                            $html .= '<p>Unable to map your domain with your microsite.</p>';
                            $html .= '</div>';
                            $html .= '<p>Please contact our support for more information or read our documentation.</p>';
                            $html .= '</div>';
                        }
                    } else {
                        if ($blog_exists == TRUE || $improper_domain == TRUE) {
                            $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                            $html .= '<span class="avia_message_box_title">Note</span>';
                            $html .= '<div class="avia_message_box_content">';
                            $html .= '<span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>';
                            $html .= '<p>Please enter proper domain name or your domain already exists in our directory.</p>';
                            $html .= '</div>';
                            $html .= '<p>Please try again.</p>';
                            $html .= '</div>';
                        }
                    }
                } else {
                    $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                    $html .= '<span class="avia_message_box_title">Error</span>';
                    $html .= '<div class="avia_message_box_content">';
                    $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
                    $html .= '<p>Please Enter Unique Domain Name</p>';
                    $html .= '</div>';
                    $html .= '</div>';
                }
            } else {
                $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                $html .= '<span class="avia_message_box_title">Error</span>';
                $html .= '<div class="avia_message_box_content">';
                $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
                $html .= '<p>Please upgrade your package. You have consumed the total site allowed.</p>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        
        // This is where we need to control themes. This gets all admin themese, however not all themes should be available to all users.
        $themes = get_blogs_of_user('1');    # Admin
        
        if($counter_details[0]->site_allowed > $counter_details[0]->site_consumed){
            $html .= '<div class="avia_message_box avia-color-blue avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-1  el_after_av_notification  el_before_av_notification ">';
            $html .= '<span class="avia_message_box_title">Note</span>';
            $html .= '<div class="avia_message_box_content">';
            $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
            $html .= '<p>You have consumed <span class="sites-consumed">'.$counter_details[0]->site_consumed.'</span> site(s) out of '.$counter_details[0]->site_allowed.' allowed.</p>';
            $html .= '</div>';
            $html .= '</div>';            
        }elseif($counter_details[0]->site_allowed == $counter_details[0]->site_consumed){
            $user_ID = get_current_user_id();
            $table = $wpdb->base_prefix . "orders";
            $data = array('status'=>0);
            $where = array('user_id'=>$user_ID, 'status'=>1);
            $where_format = array('%d','%d');
            $result = $wpdb->update( $table, $data, $where, $format = null, $where_format);
            $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
            $html .= '<span class="avia_message_box_title">Error</span>';
            $html .= '<div class="avia_message_box_content">';
            $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
            $html .= '<p>You have consumed all the sites allowed by your current package. Please <a href="/pricing/" title="View Pricing">upgrade</a> your package.</p>';
            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '<form id="create-site-form" method="POST">';

        $html .= '<div class="">';

        $html .= '<label>Template: </label>';
        $html .= '<select name="template">';
        foreach ($themes AS $theme) {
            if ($theme->userblog_id > 1 && $theme->site_id == 1) {
                $html .= '<option value="' . $theme->userblog_id . '">' . $theme->blogname . '</option>';
            }
        }
        $html .= '</select>';

        $html .= '<label>Domain: </label>';
        $html .= '<input id="domain" placeholder="Eg. example.com" type="text" name="domain" value="">';

        $html .= '<label>Site Title: </label>';
        $html .= '<input id="site_title" type="text" placeholder="Eg. Your Business name" name="site_title" value="">';

        $html .= '<input type="hidden" name="user_id" value="' . get_current_user_id() . '">';
        $html .= '<input type="submit" name="submit" value="Create Site">';

        $html .= '</div>';

        $html .= '</form>';

        return $html;
    } else {
        $html = '';
        $package_settings = get_option('mism_package_settings');
        if ($package_settings['package_not_active'] != "") {
            $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
            $html .= '<span class="avia_message_box_title">Package Activation Required!</span>';
            $html .= '<div class="avia_message_box_content">';
            $html .= '<span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>';
            $html .= '<p>You need to purchase a package in order to create a new site. Please <a href="' . $package_settings['package_not_active'] . '">click here</a> to visit packages.</p>';
            $html .= '</div>';
            $html .= '</div>';
        } else {
            wp_die('You must set package not active url under package settings section.');
        }
        return $html;
    }
}

/* General Functions */

function convertToAlias($name) {
    $alias = str_replace(" ", "-", strtolower($name));
    return $alias;
}

function getSubdomainName($domain) {
    $domain = strtolower(str_replace(' ', '', $domain));
    $domain_splits = explode('.', $domain);
    if (count($domain_splits) == "2") {
        $subdomain = $domain_splits[0];
    } elseif (count($domain_splits) == "3") {
        $subdomain = $domain_splits[1];
    }
    return $subdomain;
}

/**
 *
 * @global type $wpdb
 * @param int $clone_from_blog_id the blog id which we are going to clone
 * @param int $clone_to_blog_id the blog id in which we are cloning
 */
function mism_clone_blog($clone_from_blog_id, $clone_to_blog_id) {

    global $wpdb;

    //the table prefix for the blog we want to clone
    $old_table_prefix = $wpdb->get_blog_prefix($clone_from_blog_id);

    //the table prefix for the target blog in which we are cloning
    $new_table_prefix = $wpdb->get_blog_prefix($clone_to_blog_id);

    if ($wpdb->base_prefix == $new_table_prefix) {
        return; # No Cloning of site, if found cloning to main site.
    }

    //which tables we want to clone
    //add or remove your table here
    //$tables = array('posts', 'comments', 'options', 'postmeta', 'terms', 'term_taxonomy', 'term_relationships', 'commentmeta','new_royalsliders');
    $tables = array('posts', 'comments', 'options', 'postmeta', 'terms', 'term_taxonomy', 'term_relationships', 'commentmeta');

    //the options that we don't want to alter on the target blog
    //we will preserve the values for these in the options table of newly created blog
    $excluded_options = array(
        'siteurl',
        'blogname',
        'blogdescription',
        'home',
        'admin_email',
        'upload_path',
        'upload_url_path',
        $new_table_prefix . 'user_roles' //preserve the roles
            //add your own keys to preserve here
    );

    //should we? I don't see any reason to do it, just to avoid any glitch
    $excluded_options = esc_sql($excluded_options);

    //we are going to use II Clause to fetch everything in single query. For this to work, we will need to quote the string
    //
    //not the best way to do it, will improve in future
    //I could not find an elegant way to quote string using sql, so here it is
    $excluded_option_list = "('" . join("','", $excluded_options) . "')";

    //the options table name for the new blog in which we are going to clone in next few seconds
    $new_blog_options_table = $new_table_prefix . 'options';

    $excluded_options_query = "SELECT option_name, option_value FROM {$new_blog_options_table} WHERE option_name IN {$excluded_option_list}";

    //let us fetch the data
    $excluded_options_data = $wpdb->get_results($excluded_options_query);

    //we have got the data which we need to update again later
    //now for each table, let us clone
    foreach ($tables as $table) {
        mism_clone_table($old_table_prefix . $table, $new_table_prefix . $table);
    }

    //update the preserved options to the options table of the clonned blog
    foreach ((array) $excluded_options_data as $excluded_option) {
        update_blog_option($clone_to_blog_id, $excluded_option->option_name, maybe_unserialize($excluded_option->option_value));
    }

    $sql = "DELETE FROM `" . $new_table_prefix . "options` WHERE option_name='" . $new_table_prefix . "user_roles'";
    $wpdb->query($sql);

    $sql = "UPDATE `" . $new_table_prefix . "options` SET option_name='" . $new_table_prefix . "user_roles' WHERE option_id='88'";
    $wpdb->query($sql);
    
    # Updated for Contact Form Cloning Patch regarding Admin Email
    // $sql = "UPDATE `" . $new_table_prefix . "postmeta` SET meta_value = REPLACE (meta_value, '{ADMINEMAIL}', '".get_option('admin_email')."') WHERE meta_value LIKE '%{ADMINEMAIL}%'";
    //    $sql = "ALTER TABLE `" . $new_table_prefix . "posts` MODIFY ID BIGINT PRIMARY KEY AUTO_INCREMENT";
    //    $wpdb->query($sql);

}

function mism_clone_table($old_table, $new_table) {
    /** @var wpdb */
    global $wpdb;

    $create_sql = $wpdb->get_var('SHOW CREATE TABLE `'.$old_table.'`', 1);
    if (!is_null($create_sql) && false !== $wpdb->query('DROP TABLE IF EXISTS `'.$new_table.'`')) {
        $create_sql = str_replace($old_table, $new_table, $create_sql);
        if (false !== $wpdb->query($create_sql)) {
            if (false === $wpdb->query('INSERT INTO `'.$new_table.'` SELECT * FROM `'.$old_table.'`')) {
                throw new Exception('Can\'t cope rows from '.$old_table.' to '.$new_table);
            }
        } else {
            throw new Exception('Can\'t create table '.$new_table. '<br/><br/>'.$create_sql);
        }
    } else {
        throw new Exception('Can\'t load table metadata '.$old_table);
    }
}

class MISM_Files {

    /**
     * Copy files from one site to another
     * @since 0.2.0
     * @param  int $from_site_id duplicated site id
     * @param  int $to_site_id   new site id
     */
    public static function copy_files($from_site_id, $to_site_id) {
        //echo "copy<br/>";
        // Switch to Source site and get uploads info
        switch_to_blog($from_site_id);
        $wp_upload_info = wp_upload_dir();
        $from_dir['path'] = str_replace(' ', "\\ ", trailingslashit($wp_upload_info['basedir']));
        $from_site_id==MISM_PRIMARY_SITE_ID ? $from_dir['exclude'] = MISM_Files::get_primary_dir_exclude() :  $from_dir['exclude'] = array();
        // Switch to Destination site and get uploads info
        switch_to_blog($to_site_id);
        $wp_upload_info = wp_upload_dir();
        $to_dir = str_replace(' ', "\\ ", trailingslashit($wp_upload_info['basedir']));

        restore_current_blog();

        $dirs = array();
        $dirs[] = array(
            'from_dir_path' => $from_dir['path'],
            'to_dir_path' => $to_dir,
            'exclude_dirs' => $from_dir['exclude'],
        );
        $dirs = apply_filters('mism_copy_dirs', $dirs, $from_site_id, $to_site_id);

        foreach ($dirs as $dir) {
            if (isset($dir['to_dir_path']) && !MISM_Files::init_dir($dir['to_dir_path'])) {
                MISM_Files::mkdir_error($dir['to_dir_path']);
            }
            MISM_Files::recurse_copy($dir['from_dir_path'], $dir['to_dir_path'], $dir['exclude_dirs']);
        }

        return true;
    }

    /**
     * Copy files from one directory to another
     * @since 0.2.0
     * @param  string $src source directory path
     * @param  string $dst destination directory path
     * @param  array  $exclude_dirs directories to ignore
     */
    public static function recurse_copy($src, $dst, $exclude_dirs = array()) {
        //echo "recurse<br/>";
        $dir = opendir($src);
        if (!is_dir($dst)) {
            mkdir($dst);
        }
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                $srcFile = str_replace('//', '/', $src . '/' . $file);
                $dstFile = str_replace('//', '/', $dst . '/' . $file);
                if (is_dir($srcFile)) {
                    if (!in_array($file, $exclude_dirs)) {

                        MISM_Files::recurse_copy($srcFile, $dstFile);
                    }
                } else {
                    copy($srcFile, $dstFile);
                }
            }
        }
        closedir($dir);
    }

    /**
     * Set a directory writable, creates it if it does not exist, or return false
     * @since 0.2.0
     * @param  string $path the path
     * @return boolean True on success, False on failure
     */
    public static function init_dir($path) {
        //echo "init<br/>";
        //$e = error_reporting(0);

        if (!is_dir($path)) {
            return mkdir($path, 0777);
        } else if (is_dir($path)) {
            if (!is_writable($path)) {
                return chmod($path, 0777);
            }
            return true;
        }

        //error_reporting($e);
        return false;
    }

    /**
     * Removes a directory and all its content
     * @since 0.2.0
     * @param  string $dir the path
     */
    public static function rrmdir($dir) {
        //echo "rrm<br/>";
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        self::rrmdir($dir . "/" . $object); else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    /**
     * Stop process on Creating dir Error, print and log error, removes the new blog
     * @since 0.2.0
     * @param  string  $dir_path the path
     */
    public static function mkdir_error($dir_path) {
        echo '<br />Duplication failed ';
        //wp_die('mkdir');
    }

    /**
     * Get directories to exclude from file copy when duplicated site is primary site
     * @since 0.2.0
     * @return  array of string
     */
    public static function get_primary_dir_exclude() {
        return array(
            'sites',
        );
    }

}

add_action('wp_footer', 'include_in_footer');

function include_in_footer() {
    ?>
    <script type="text/javascript">
      
      function updateConsumed(){
        sites_consumed = parseInt( jQuery(".sites-consumed").text(), 10 );
        console.log(sites_consumed);
        jQuery(".sites-consumed").text(sites_consumed+1);
      }
      
      jQuery(document).ready(function(){
          
          jQuery('#create-site-form').submit(function(e){
              var domain = jQuery('#domain').val(); 
              var site_title = jQuery('#site_title').val();
              if(domain=="")
              {
                  jQuery('#domain').css('border','1px solid #ff0000');
                  e.preventDefault();
              }
              else
              {
                  jQuery('#domain').css('border','1px solid #CCCCCC');
              }
                      
              if(site_title=="")
              {
                  jQuery('#site_title').css('border','1px solid #ff0000');
                  e.preventDefault();
              }
              else
              {
                  jQuery('#site_title').css('border','1px solid #CCCCCC');
              }
          });
        });
    </script>
    <?php
}

ob_end_flush();
?>
