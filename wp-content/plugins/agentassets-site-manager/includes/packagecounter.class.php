<?php

class PackageCounter {
    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'package_counter';
    }

    /**
     * @param $id
     * @return false|int - 1 if counter incremented, 0 if consumed sites is out or false if error
     */
    public static function increment($id) {
        global $wpdb;
        return $wpdb->query('UPDATE `'.self::tableName().'` SET `site_consumed` = `site_consumed` + 1 WHERE `id` = '.((int)$id).' AND `site_consumed` < `site_allowed`');
    }

    public static function incrementByOrderId($order_id) {
        global $wpdb;
        return $wpdb->query('UPDATE `'.self::tableName().'` SET `site_consumed` = `site_consumed` + 1 WHERE `order_id` = '.((int)$order_id).' AND `site_consumed` < `site_allowed`');
    }

    public static function decrement($id) {
        global $wpdb;
        return $wpdb->query('UPDATE `'.self::tableName().'` SET `site_consumed` = `site_consumed` - 1 WHERE `id` = '.((int)$id).' AND `site_consumed` <> 0');
    }

    public static function decrementByOrderId($order_id) {
        global $wpdb;
        return $wpdb->query('UPDATE `'.self::tableName().'` SET `site_consumed` = `site_consumed` - 1 WHERE `order_id` = '.((int)$order_id).' AND `site_consumed` <> 0');
    }

    public static function getCounterDetails($id) {
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM `'.self::tableName().'` WHERE `id` = '.(int)$id);
    }

    public static function getCounterDetailsByOrderId($order_id) {
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM `'.self::tableName().'` WHERE `order_id` = '.(int)$order_id);
    }

    public static function createCounter($order_id, $site_allowed, $site_consumed = 0) {
        $result = false;
        global $wpdb;
        if ($wpdb->insert(self::tableName(), array(
            'order_id' => $order_id,
            'site_consumed' => $site_consumed,
            'site_allowed' => $site_allowed,
        ), array('%d','%d','%d'))) {
            $result = $wpdb->insert_id;
        }
        return $result;
    }

    public static function getIdByOrder($order_id) {
        global $wpdb;
        return $wpdb->get_var('SELECT `id` FROM `'.self::tableName().'` WHERE `order_id` = '.(int)$order_id . ' LIMIT 1');
    }
}