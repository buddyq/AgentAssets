<?php
define('MISM_PRIMARY_SITE_ID', 1);
ob_start();
/* Create New Site | Shortcode */

add_shortcode('create_new_site', 'mism_create_new_site');

class MismCreateNewSiteNotify {
    public static $notifyOptions = array();
    public static $link = null;
    public static $subdomainLink = null;
    public static $adminLink = null;
    public static $additionalContent = null;

    public static $content = null;
    public static $secondContent = null;

    protected static $hasSuccessNotify = false;
    protected static $hasErrorNotify = false;


    public static function successNotify($options = array()) {
        self::$notifyOptions = array_merge(array(
            'color' => 'green',
            'size' => 'large',
            'icon' => '',
            'icon_font' => 'entypo',
            'title' => __('Success', 'mism'),
        ), $options);

        self::$hasSuccessNotify = true;
    }

    public static function errorNotify($options = array()) {
        self::$notifyOptions = array_merge(array(
            'color' => 'red',
            'size' => 'large',
            'icon' => '',
            'icon_font' => 'entypo-fontello',
            'title' => 'Note',
        ), $options);

        self::$hasErrorNotify = true;
    }

    public static function successNotifyShortcode($atts, $content) {
        $html = '';
        if (!empty($content)) {
            self::$content = $content;
            self::$secondContent = null;
        }
        if (self::$hasSuccessNotify) {
            // $html = MedmaHelper::getAviaMessageBox(self::$content, self::$secondContent, self::$notifyOptions);
            if (!empty(self::$additionalContent)) {
                $html .= self::$additionalContent;
            }
        }
        return do_shortcode($html);
    }

    public static function successLinkShortcode() {
        $html = '';
        if (!empty(self::$link)) {
            $html = '<a href="'.self::$link.'">'.self::$link.'</a>';
        }
        return $html;
    }

    public static function successSubdomainLinkShortcode() {
        $html = '';
        if (!empty(self::$subdomainLink)) {
            $html = '<a href="'.self::$subdomainLink.'">'.self::$subdomainLink.'</a>';
        }
        return $html;
    }

    public static function successAdminLinkShortcode() {
        $html = '';
        if (!empty(self::$adminLink)) {
            $html = '<a href="'.self::$adminLink.'">'.self::$adminLink.'</a>';
        }
        return $html;
    }

    public static function errorNotifyShortcode($atts, $content) {
        $html = '';
        if (!empty($content)) {
            self::$content = $content;
            self::$secondContent = null;
        }
        if (self::$hasErrorNotify) {
            // $html = MedmaHelper::getAviaMessageBox(self::$content, self::$secondContent, self::$notifyOptions);
            if (!empty(self::$additionalContent)) {
                $html .= self::$additionalContent;
            }
        }
        return do_shortcode($html);
    }
}

add_shortcode('create_new_site_success', array('MismCreateNewSiteNotify', 'successNotifyShortcode'));
add_shortcode('create_new_site_error', array('MismCreateNewSiteNotify', 'errorNotifyShortcode'));
add_shortcode('create_new_site_link', array('MismCreateNewSiteNotify', 'successLinkShortcode'));
add_shortcode('create_new_site_subdomain_link', array('MismCreateNewSiteNotify', 'successSubdomainLinkShortcode'));
add_shortcode('create_new_site_admin_link', array('MismCreateNewSiteNotify', 'successAdminLinkShortcode'));


function mism_create_new_site($atts)
{
    global $wpdb;

    $atts = shortcode_atts(
        array(
            'title' => '',
        ), $atts, 'create_new_site');

    #   User Package Authentication Check
    $order = OrderModel::findOne('`user_id` = %d AND `status` = %d AND `expiry_date` >= %s',
        array(get_current_user_id(), OrderModel::STATUS_PAID, date('Y-m-d H:i:s')));

    if ($order) { # If Package Purchased, then continue
        $html = '';

        # Site Allowed Authentication
        $counter_details = PackageCounter::getCounterDetailsByOrderId($order->id);

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
            if ($_SERVER['HTTP_HOST'] == "aasg.com" || $_SERVER['HTTP_HOST'] == "192.168.0.210") { # HTTP HOST for Local Development Server
                $domain = $_SERVER['HTTP_HOST'];
                $path = "/" . $blogname;
            } else { # HTTP HOST automatically defined for LIVE server
                $domain = $blogname . "." . $_SERVER['HTTP_HOST'];
                $path = "/";
            }

            $siteTitle = $_POST['site_title'];
            $userID = $_POST['user_id'];

            # Package Authentication
            if ($counter_details->site_allowed >= $counter_details->site_consumed) { # Check for Package whether there is site available
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
                        mism_clone_blog($specified_blog_id, $blog_id, $domain);

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

                        $ip = get_option('msm_main_site_ip', '');
                        $main_site_port = get_option('msm_main_site_port', '');
                        $main_site_output_type = get_option('msm_main_site_output_type', '');
                        $main_site_account = get_option('msm_main_site_account', '');
                        $main_site_cpanel_username = get_option('msm_main_site_cpanel_username', '');
                        $main_site_cpanel_password = get_option('msm_main_site_cpanel_password', '');

                        $package_duration = get_post_meta($order->package_id, 'wpcf-duration', true);
                        restore_current_blog();

                        # Connecting to cPanel API for communicating with Domain's parking
                        if (!empty($ip) && !empty($main_site_port) && !empty($main_site_output_type) && !empty($main_site_account) && !empty($main_site_cpanel_username) && !empty($main_site_cpanel_password)) {
                            $xmlapi = new xmlapi($ip);
                            $xmlapi->set_port($main_site_port);
                            $xmlapi->set_output($main_site_output_type);

                            # Authenticating with cPanel API using login credentials
                            $xmlapi->password_auth($main_site_cpanel_username, $main_site_cpanel_password);
                            $xmlapi->set_debug(1);

                            $arg = array(
                                // 'dir' => 'public_html',
                                'domain' => $externalDomain,
                                'topdomain' => $blogname
                            );

                            //Just need the username of the cpanel account here. Password is handled above in password auth
                            $result = $xmlapi->api2_query($main_site_cpanel_username, 'Park', 'park', $arg);

                            if ($result) {
                                # Update Package Status
                                OrderMap::addNewRelation($userID, $blog_id, $order->id, $package_duration);
                                $domain_map_status = true;

                                
                                ?>
                                <div
                                    class="avia_message_box avia-color-green avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-0  el_before_av_notification  avia-builder-el-first ">
                                    <span class="avia_message_box_title"><?php _e('Success', 'mism'); ?></span>

                                    <div class="avia_message_box_content">
                                        <span class="avia_message_box_icon" aria-hidden="true" data-av_icon=""
                                              data-av_iconfont="entypo-fontello"></span>

                                        <p><?php _e('Site created successfully.', 'mism'); ?></p>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    jQuery(function () {
                                        updateConsumed();
                                    });
                                </script>
                                <?php
                                
                                MismCreateNewSiteNotify::$additionalContent = '<script type="text/javascript">'
                                    .'    jQuery(function () {'
                                    .'        updateConsumed();'
                                    .'    });'
                                    .'</script>';
                                MismCreateNewSiteNotify::$content =  __('Site created successfully.', 'mism');
                                MismCreateNewSiteNotify::$link = 'http://'.$externalDomain;
                                MismCreateNewSiteNotify::$subdomainLink = 'http://'.$domain;
                                MismCreateNewSiteNotify::$adminLink = 'http://'.$domain.'/wp-admin';
                                MismCreateNewSiteNotify::successNotify();
                            } else {
                          
                                $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                                $html .= '<span class="avia_message_box_title">Note</span>';
                                $html .= '<div class="avia_message_box_content">';
                                $html .= '<span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>';
                                $html .= '<p>Unable to map your domain with your microsite.</p>';
                                $html .= '</div>';
                                $html .= '<p>Please contact our support for more information or read our documentation.</p>';
                                $html .= '</div>';
                                
                                MismCreateNewSiteNotify::$content = 'Unable to map your domain with your microsite.';
                                MismCreateNewSiteNotify::$secondContent = 'Please contact our support for more information or read our documentation.';
                                MismCreateNewSiteNotify::errorNotify();
                            }
                        } else {
                            OrderMap::addNewRelation($userID, $blog_id, $order->id, $package_duration);
                            
                            $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                            $html .= '<span class="avia_message_box_title">Note</span>';
                            $html .= '<div class="avia_message_box_content">';
                            $html .= '<span data-av_iconfont="entypo-fontello" data-av_icon="" aria-hidden="true" class="avia_message_box_icon"></span>';
                            $html .= '<p>Unable to map your domain with your microsite.</p>';
                            $html .= '</div>';
                            $html .= '<p>Please contact our support for more information or read our documentation.</p>';
                            $html .= '</div>';
                            
                            MismCreateNewSiteNotify::$content = 'Unable to map your domain with your microsite.';
                            MismCreateNewSiteNotify::$secondContent = 'Please contact our support for more information or read our documentation.';
                            MismCreateNewSiteNotify::errorNotify();
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
                            
                            MismCreateNewSiteNotify::$content = 'Please enter proper domain name or your domain already exists in our directory.';
                            MismCreateNewSiteNotify::$secondContent = 'Please try again.';
                            MismCreateNewSiteNotify::errorNotify();
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
                    
                    MismCreateNewSiteNotify::$content = 'Please Enter Unique Domain Name';
                    MismCreateNewSiteNotify::errorNotify(array('title' => 'Error'));
                }
            } else {
                
                $html .= '<div class="avia_message_box avia-color-red avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-2  el_after_av_notification  el_before_av_notification ">';
                $html .= '<span class="avia_message_box_title">Error</span>';
                $html .= '<div class="avia_message_box_content">';
                $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
                $html .= '<p>Please upgrade your package. You have consumed the total site allowed.</p>';
                $html .= '</div>';
                $html .= '</div>';
                
                MismCreateNewSiteNotify::$content = 'Please upgrade your package. You have consumed the total site allowed.';
                MismCreateNewSiteNotify::errorNotify(array('title' => 'Error'));
            }
        }

        return $html;
    }
}

add_shortcode('create_new_site_form', 'mism_create_new_site_form');

function mism_create_new_site_form($atts) {
    global $wpdb;

    $atts = shortcode_atts(
        array(
            'title' => '',
        ), $atts, 'create_new_site');

    #   User Package Authentication Check
    $order = OrderModel::findOne('`user_id` = %d AND `status` = %d AND `expiry_date` >= %s',
        array(get_current_user_id(), OrderModel::STATUS_PAID, date('Y-m-d H:i:s')));

    if ($order) { # If Package Purchased, then continue
        $html = '';

        $counter_details = PackageCounter::getCounterDetailsByOrderId($order->id);
        echo "<pre>";print_r($counter_details);"</pre>";
        // This is where we need to control themes. This gets all admin themes, however not all themes should be available to all users.
        $themes = get_blogs_of_user('2');    # Admin

        // $html .= MedmaHelper::getConsumedSitesMessageBox($counter_details);
        if ($counter_details->site_allowed > $counter_details->site_consumed) {
            $html .= '<div class="avia_message_box avia-color-blue avia-size-large avia-icon_select-yes avia-border-  avia-builder-el-1  el_after_av_notification  el_before_av_notification ">';
            $html .= '<span class="avia_message_box_title">Note</span>';
            $html .= '<div class="avia_message_box_content">';
            $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="" data-av_iconfont="entypo-fontello"></span>';
            $html .= '<p>You have consumed <span class="sites-consumed">' . $counter_details->site_consumed . '</span> site(s) out of ' . $counter_details->site_allowed . ' allowed.</p>';
            $html .= '</div>';
            $html .= '</div>';
        } elseif ($counter_details->site_allowed == $counter_details->site_consumed) {
            $user_ID = get_current_user_id();

            // WTF?
            $table = $wpdb->base_prefix . "orders";
            $data = array('status' => 0);
            $where = array('user_id' => $user_ID, 'status' => 1);
            $where_format = array('%d', '%d');
            $result = $wpdb->update($table, $data, $where, $format = null, $where_format);
            //

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
                $theme_system_id = get_blog_option($theme->userblog_id, 'stylesheet');
                if (MedmaThemeManager::checkAccess($theme_system_id)) {
                    $groups = '';
                    $themeObject = MedmaThemeManager::findOne('theme_system_id = %s', array($theme_system_id));
                    if ($themeObject && $themeObject->status == MedmaThemeManager::STATUS_AUTHORIZED) {
                        $themeGroups = MedmaThemeManager::getThemeGroups($theme_system_id);
                        if ($themeGroups) {
                            $groupsNames = array();
                            foreach ($themeGroups as $themeGroup) {
                                $groupsNames[] = $themeGroup->name;
                            }
                            $groups = '('.implode(', ', $groupsNames) . ')';
                        }
                    }
                    $html .= '<option value="' . $theme->userblog_id . '">' . $theme->blogname . ' ' . $groups . '</option>';
                }
            }
        }
        $html .= '</select>';

        $html .= '<label>Domain: </label>';
        $html .= '<input id="domain" placeholder="Eg. example.com" type="text" name="domain" value="">';

        $html .= '<label>Site Title: </label>';
        $html .= '<input id="site_title" type="text" placeholder="Eg. Your Business name" name="site_title" value="">';

        $html .= '<input type="hidden" name="user_id" value="' . get_current_user_id() . '">';
        $html .= '<input type="submit" name="submit" value="Create Site!">';

        $html .= '</div>';

        $html .= '</form>';
        return $html;
    } else {
        $html = '';
        switch_to_blog(1);
        $package_settings = get_option('mism_package_settings');
        restore_current_blog();
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

function convertToAlias($name)
{
    $alias = str_replace(" ", "-", strtolower($name));
    return $alias;
}

function getSubdomainName($domain)
{
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
function mism_clone_blog($clone_from_blog_id, $clone_to_blog_id, $domain)
{

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
        '',
        $new_table_prefix . 'user_roles' //preserve the roles
        //add your own keys to preserve here
    );

    //should we? I don't see any reason to do it, just to avoid any glitch
    $excluded_options = esc_sql($excluded_options);

    //we are going to use II Clause to fetch everything in single query. For this to work, we will need to quote the string

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
        medma_clone_table($old_table_prefix . $table, $new_table_prefix . $table);
    }

    //update the preserved options to the options table of the clonned blog
    foreach ((array)$excluded_options_data as $excluded_option) {
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


    // revslider data migration
    $drop_options = array();

    switch_to_blog($clone_from_blog_id);
    $wp_upload_info = wp_upload_dir();
    $from_dir = str_replace(' ', "\\ ", trailingslashit($wp_upload_info['basedir']));
    // Switch to Destination site and get uploads info
    switch_to_blog($clone_to_blog_id);
    $wp_upload_info = wp_upload_dir();
    $to_dir = str_replace(' ', "\\ ", trailingslashit($wp_upload_info['basedir']));
    $from_dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', $from_dir);
    $to_dir = str_replace($_SERVER['DOCUMENT_ROOT'], '', $to_dir);


    $checkRevsliderTables = $wpdb->query('SHOW TABLES LIKE "'.$wpdb->get_blog_prefix($clone_from_blog_id) .'revslider_css"');
    $result = (1 === $checkRevsliderTables);
    if ($result) {
        $status = medma_clone_factory($clone_from_blog_id, $clone_to_blog_id, array(
            'db' => array(
                'tables' => array(
                    'revslider_css',
                    'revslider_layer_animations',
                    'revslider_navigations',
                    'revslider_sliders' /* => array(
                        'row_filter' => 'mcf_replaceFilename',
                        'columns' => array('params'),
                    )*/,
                    'revslider_slides' /* => array(
                        'row_filter' => 'mcf_replaceFilename',
                        'columns' => array('params', 'layers', 'settings'),
                    )*/,
                    'revslider_static_slides' /* => array(
                        'row_filter' => 'mcf_replaceFilename',
                        'columns' => array('params', 'layers'),
                    )*/,
                ),
                'params' => array(
                    'replace' => array(
                        'path' => array(
                            'search' =>  str_replace('/', '\/', $from_dir),
                            'replace' => str_replace('/', '\/', $to_dir),
                        ),
                        'domain' => array(
                            'search' => str_replace('http://', '', get_blog_option($clone_from_blog_id, 'siteurl')),
                            'replace' => $domain,
                        ),
                        'localfix' => array( //todo remove for production
                            'search' => 'athena.agentassets.com',
                            'replace' => $domain,
                        )
                    ),
                ),
            ),
        ));
    } else {
        $drop_options = array(
            'revslider_table_version' // fix revslider tables updating bug
        );
    }

    // drop Agent Information data from template site
    $agentInformationObject = new AgentInformationModel();
    foreach($agentInformationObject->attributesMetadata() as $key => $data) {
        $drop_options[] = AgentInformationModel::OPTION_PREFIX . $key;
    }

    $drop_options_list =  "('" . join("','", $drop_options) . "')";
    $wpdb->query("DELETE FROM {$new_blog_options_table} WHERE option_name IN {$drop_options_list}");
}

class MISM_Files
{

    /**
     * Copy files from one site to another
     *
     * @param $from_site_id
     * @param $to_site_id
     * @return bool
     */
    public static function copy_files($from_site_id, $to_site_id)
    {
        // Switch to Source site and get uploads info
        switch_to_blog($from_site_id);
        $wp_upload_info = wp_upload_dir();
        $from_dir['path'] = str_replace(' ', "\\ ", trailingslashit($wp_upload_info['basedir']));
        $from_site_id == MISM_PRIMARY_SITE_ID ? $from_dir['exclude'] = MISM_Files::get_primary_dir_exclude() : $from_dir['exclude'] = array();
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
     * @param  array $exclude_dirs directories to ignore
     */
    public static function recurse_copy($src, $dst, $exclude_dirs = array())
    {
        //echo "recurse<br/>";
        $dir = opendir($src);
        if (!is_dir($dst)) {
            mkdir($dst);
        }
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
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
    public static function init_dir($path)
    {
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
    public static function rrmdir($dir)
    {
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
     * @param  string $dir_path the path
     */
    public static function mkdir_error($dir_path)
    {
        echo '<br />Duplication failed ';
        //wp_die('mkdir');
    }

    /**
     * Get directories to exclude from file copy when duplicated site is primary site
     * @since 0.2.0
     * @return  array of string
     */
    public static function get_primary_dir_exclude()
    {
        return array(
            'sites',
        );
    }

}

add_action('wp_footer', 'include_in_footer');

function include_in_footer()
{
    ?>
    <script type="text/javascript">

        function updateConsumed() {
            sites_consumed = parseInt(jQuery(".sites-consumed").text(), 10);
            console.log(sites_consumed);
            jQuery(".sites-consumed").text(sites_consumed + 1);
        }

        jQuery(document).ready(function () {

            jQuery('#create-site-form').submit(function (e) {
                var domain = jQuery('#domain').val();
                var site_title = jQuery('#site_title').val();
                if (domain == "") {
                    jQuery('#domain').css('border', '1px solid #ff0000');
                    e.preventDefault();
                }
                else {
                    jQuery('#domain').css('border', '1px solid #CCCCCC');
                }

                if (site_title == "") {
                    jQuery('#site_title').css('border', '1px solid #ff0000');
                    e.preventDefault();
                }
                else {
                    jQuery('#site_title').css('border', '1px solid #CCCCCC');
                }
            });
        });
    </script>
    <?php
}

ob_end_flush();
?>
