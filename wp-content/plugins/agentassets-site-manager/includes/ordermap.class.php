<?php

class OrderMap {
    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'order_map';
    }

    public static function extendSite($blog_id) {
        global $wpdb;
        $status = false;

        $duration = 0;
        $order = OrderModel::findOne('`user_id` = %d AND `status` = %d AND `expiry_date` >= %s',
            array(get_current_user_id(), OrderModel::STATUS_PAID, date('Y-m-d H:i:s')));
        if ($order) {
            switch_to_blog(1);
            $duration = get_post_meta($order->package_id, 'wpcf-duration', true);
            restore_current_blog();
        }

        if ($duration) {
            $wpdb->query('START TRANSACTION');
            while(true) {
                if (1 !== PackageCounter::incrementByOrderId($order->id)) break;
                $blog_map = self::getBlogInfo($blog_id);

                if (!$blog_map) break;
                
                // if ($expiry_timestamp < time()) {
                //     $expiry_timestamp = time();
                // }
                
                
                if ($blog_map->days_left > 0) {
                  $expiry_timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $blog_map->expiry_date)->getTimestamp();
                }else{
                  $expiry_timestamp = time();
                }
                $new_expiry = date('Y-m-d H:i:s', strtotime("+$duration month", $expiry_timestamp));
                if (1 !== $wpdb->update(
                    self::tableName(),
                    array('expiry_date' => $new_expiry),
                    array('order_map_id' => $blog_map->order_map_id),
                    array('%s'),
                    array('%d')
                )) break;

                error_log(print_r('deleted: '.get_blog_status($blog_id, 'deleted'),true));
                if (0 != get_blog_status($blog_id, 'deleted')) {
                    update_blog_status($blog_id, 'deleted', 0);
                }

                $status = true;
                break;
            }

            if ($status) {
                $wpdb->query('COMMIT');
            } else {
                $wpdb->query('ROLLBACK');
            }
        }

        return $status;
    }

    public static function addNewRelation($user_id, $blog_id, $order_id, $duration) {
        $status = false;
        global $wpdb;

        $create_date = date('Y-m-d H:i:s', time());
        $expiry_date = date('Y-m-d H:i:s', strtotime("+$duration month"));

        $counter_id = PackageCounter::getIdByOrder($order_id);
        if ($counter_id && 1 === PackageCounter::increment($counter_id)) {
            $result = $wpdb->insert(self::tableName(), array(
                'user_id'     => $user_id,
                'site_id'     => $blog_id,
                'counter_id'  => $counter_id,
                'create_date' => $create_date,
                'expiry_date' => $expiry_date,
            ), array('%d','%d','%d', '%s', '%s'));
            $status = ($result === 1);
        }
        return $status;
    }


    public static function getBlogOwner($blog_id) {
        /** @var wpdb */
        global $wpdb;
        return $wpdb->get_var('SELECT `user_id` FROM `'.self::tableName().'` WHERE `site_id` = '.(int)$blog_id . ' LIMIT 1');
    }

    public static function getBlogInfo($blog_id) {
        /** @var wpdb */
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM `'.self::tableName().'` WHERE `site_id` = '.(int)$blog_id . ' LIMIT 1');
    }

    public static function getUserBlogsMap($user_id) {
        global $wpdb;
        return $wpdb->get_results('SELECT * FROM `'.self::tableName().'` WHERE `user_id` = '.(int)$user_id);
    }

    public static function getUserBlogIds($user_id) {
        /* @var wpdb */
        global $wpdb;
        return $wpdb->get_col('SELECT `site_id` FROM `'.self::tableName().'` WHERE `user_id` = '.(int)$user_id);
    }

    public static function getUserBlogsDetailed($user_id) {
        return self::getAllBlogsDetails('`user_id` = %d', array($user_id));
    }

    public static function getAllBlogsDetails($condition = '', $params = array()) {
        global $wpdb;
        $where = empty($condition) ? '' : ' WHERE '.$condition;
        $map = $wpdb->get_results($wpdb->prepare('SELECT * FROM `'.self::tableName().'` '.$where, $params));
        $blogs = array();
        foreach($map as $blogMapInfo) {
            $blog = get_blog_details($blogMapInfo->site_id);
            $dtime = DateTime::createFromFormat('Y-m-d H:i:s', $blogMapInfo->expiry_date);
            $days_left = (int)(($dtime->getTimestamp() - time()) / (3600*24)) + 1;
            if ($days_left < 0) {
                $days_left = 0;
            }
            $blogs[ $blogMapInfo->site_id ] = (object) array(
                'userblog_id' => $blogMapInfo->site_id,
                'blogname'    => $blog->blogname,
                'domain'      => $blog->domain,
                'path'        => $blog->path,
                'site_id'     => $blog->site_id,
                'siteurl'     => $blog->siteurl,
                'archived'    => $blog->archived,
                'mature'      => $blog->mature,
                'spam'        => $blog->spam,
                'deleted'     => $blog->deleted,
                'create_date' => $blogMapInfo->create_date,
                'expiry_date' => $blogMapInfo->expiry_date,
                'days_left'   => $days_left,
            );
        }
        return $blogs;
    }

    public static function dropRelation($blog_id) {
        /** @var wpdb */
        global $wpdb;
        $blogInfo = self::getBlogInfo($blog_id);
        if ($blogInfo) {
            //PackageCounter::decrement($blogInfo->counter_id);
            $wpdb->query('DELETE FROM `'.self::tableName().'` WHERE `site_id` = '.(int)$blog_id);
        }
    }
}