<?php

//multisite logic
add_filter('wpmu_drop_tables', 'wpmi_drop_tables', 10, 2);

//themes
add_filter('all_themes', 'medma_all_themes_filter');
add_filter('wp_prepare_themes_for_js', 'medma_all_themes_filter');

function wpmi_drop_tables($tables, $blog_id) {
    /** @var wpdb */
    global $wpdb;
    $prefix = $wpdb->get_blog_prefix( $blog_id );
    $all_tables = $wpdb->get_col('SHOW TABLES FROM `'.DB_NAME.'` WHERE LOCATE("'.$prefix.'", `Tables_in_'.DB_NAME.'`) = 1');
    if (is_array($all_tables)) foreach ($all_tables as $table) {
        if (!in_array($table, $tables)) {
            $tables[] = $table;
        }
    }
    return $tables;
}

function medma_all_themes_filter($themes) {
    if (!is_super_admin()) {
        foreach($themes as $theme_system_id => $theme) {
            if (!MedmaThemeManager::checkAccess($theme_system_id)) {
                unset($themes[$theme_system_id]);
            }
        }
    }

    return $themes;
}
