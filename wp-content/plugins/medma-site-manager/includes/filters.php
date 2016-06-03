<?php

add_filter('wpmu_drop_tables', 'wpmi_drop_tables', 10, 2);

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