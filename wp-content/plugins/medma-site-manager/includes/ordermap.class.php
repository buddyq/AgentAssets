<?php

class OrderMap {
    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'order_map';
    }

    public static function addNewRelation($user_id, $blog_id, $order_id) {
        global $wpdb;

        $counterTable = $wpdb->base_prefix . 'package_counter';
        $counter_id = $wpdb->get_var('SELECT `id` FORM `'.$counterTable.'` WHERE `order_id` = '.(int)$order_id);
        if ($counter_id && $wpdb->query('UPDATE `'.$counterTable.'` SET `site_consumed` = `site_consumed` + 1 WHERE `id` = '.(int)$counter_id )) {   $order_maping = $wpdb->insert(self::tableName(), array(
                'user_id' => $user_id,
                'site_id' => $blog_id,
                'counter_id' => $counter_id
            ), array(
                    '%d',
                    '%d',
                    '%d'
                )
            );
        }
    }

    public static function getBlogOwner($blog_id) {
        /** @var wpdb */
        global $wpdb;
        return $wpdb->get_var('SELECT `user_id` FROM `'.self::tableName().'` WHERE `blog_id` = '.(int)$blog_id . ' LIMIT 1');
    }

    public static function getBlogInfo($blog_id) {
        /** @var wpdb */
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM `'.self::tableName().'` WHERE `site_id` = '.(int)$blog_id . ' LIMIT 1');
    }

    public static function getUserBlogIds($user_id) {
        /* @var wpdb */
        global $wpdb;
        return $wpdb->get_col('SELECT `site_id` FROM `'.self::tableName().'` WHERE `user_id` = '.(int)$user_id);
    }

    public static function getUserBlogsDetailed($user_id) {
        $ids = self::getUserBlogIds($user_id);
        $blogs = array();
        foreach($ids as $blog_id) {
            $blog = get_blog_details($blog_id);
            $blogs[ $blog_id ] = (object) array(
                'userblog_id' => $blog_id,
                'blogname'    => $blog->blogname,
                'domain'      => $blog->domain,
                'path'        => $blog->path,
                'site_id'     => $blog->site_id,
                'siteurl'     => $blog->siteurl,
                'archived'    => $blog->archived,
                'mature'      => $blog->mature,
                'spam'        => $blog->spam,
                'deleted'     => $blog->deleted,
            );
        }
        return $blogs;
    }

    public static function dropRelation($blog_id) {
        /** @var wpdb */
        global $wpdb;
        $blogInfo = self::getBlogInfo($blog_id);
        if ($blogInfo && $wpdb->query('UPDATE `'.$wpdb->base_prefix . 'package_counter` SET `site_consumed` = `site_consumed` - 1 WHERE `id` = '.$blogInfo->counter_id)) {
            $wpdb->delete($wpdb->base_prefix . self::tableName(), 'blog_id = ' . (int)$blog_id);
        }
    }
}