<?php

add_action( 'delete_blog', 'mism_blog_delete', 10, 2 );

/**
 * @param int $blog_id Blog ID
 * @param bool $drop True if blog's table should be dropped. Default is false.
 */
function mism_blog_delete( $blog_id, $drop )
{
    if ($drop) {
        /** @var wpdb */
        global $wpdb;
        $blogInfo = OrderMap::getBlogInfo($blog_id);
        if ($wpdb->query('UPDATE `'.$wpdb->base_prefix . 'package_counter` SET `site_consumed` = `site_consumed` - 1 WHERE `id` = '.$blogInfo->counter_id)) {
            OrderMap::dropRelation($blog_id);
        }

        wpmu_delete_blog();
    }
}