<?php

add_action( 'delete_blog', 'mism_blog_delete', 10, 2 );

/**
 * @param int $blog_id Blog ID
 * @param bool $drop True if blog's table should be dropped. Default is false.
 */
function mism_blog_delete( $blog_id, $drop )
{
    if ($drop) {
        OrderMap::dropRelation($blog_id);
    }
}