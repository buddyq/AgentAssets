<?php

class OrderModel {
    const STATUS_NONE = 0;
    const STATUS_PAID = 1;
    const STATUS_PENDING = 2;

    public static function getStatusLabels() {
        return array(
            self::STATUS_NONE => '',
            self::STATUS_PAID => 'Paid',
            self::STATUS_PENDING => 'Pending'
        );
    }

    public static function getStatusLabel($status) {
        $labels = self::getStatusLabels();
        return $labels[$status];
    }

    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'orders';
    }

    public static function findOne($condition = '', $params = array()) {
        global $wpdb;
        $where = empty($condition) ? '' : 'WHERE '.$condition . ' LIMIT 1';
        return $wpdb->get_row($wpdb->prepare('SELECT * FROM `'.self::tableName().'` '.$where, $params));
    }

    public static function findAll($condition = '', $params = array()) {
        global $wpdb;
        $where = empty($condition) ? '' : 'WHERE '.$condition;
        return $wpdb->get_results($wpdb->prepare('SELECT * FROM `'.self::tableName().'` '.$where, $params));
    }

    public static function orderFactory($user_id, $package_id, $discount = 0, $tax = 0) {
        //todo
    }

    protected static function insertOrder($attributes) {
        $result = false;
        global $wpdb;
        if ($wpdb->insert(self::tableName(), array(
                'package_id'        => $attributes['package_id'],
                'user_id'           => $attributes['user_id'],
                'package_name'      => $attributes['package_name'],
                'package_price'     => $attributes['package_price'],
                'discount'          => $attributes['discount'],
                'tax'               => $attributes['tax'],
                'total_price'       => $attributes['total_price'],
                'purchased_data'    => $attributes['total_price'],
                'expiry_date'       => $attributes['expiry_date'],
                'status'            => $attributes['status'],
            ), array(
                '%d',
                '%d',
                '%s',
                '%s',
                '%d',
                '$d',
                '%s',
                '%s',
                '%s',
                '%d',
            )
        )) {
            $result = $wpdb->insert_id;
        }
        return $result;
    }
}