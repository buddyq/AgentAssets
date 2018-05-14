<?php

class EnomDomainModel {
    const STATUS_PENDING = 0;
    const STATUS_PAID = 1;
    const STATUS_ACTIVE = 2;

    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'enom_domains';
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

    public static function insert($attributes) {
        $result = false;
        global $wpdb;
        if ($wpdb->insert(self::tableName(), array(
            'tld'               => $attributes['tld'],
            'sld'               => $attributes['sld'],
            'user_id'           => $attributes['user_id'],
            'price'             => $attributes['price'],
            'expire'            => $attributes['expire'],
            'status'            => $attributes['status'],
        ), array(
                '%s',
                '%s',
                '%d',
                '%f',
                '%d',
                '%d',
            )
        )) {
            $result = $wpdb->insert_id;
        }
        return $result;
    }

    public static function update($attributes, $where) {
        global $wpdb;

        $fields = array();
        foreach ( $attributes as $field => $value ) {
            $fields[] = "`$field` = '" . $value . "'";
        }
        $fields = implode( ', ', $fields );

        $sql = 'UPDATE `'.self::tableName().'` SET '.$fields.' WHERE '.$where;
        return $wpdb->query($wpdb->prepare($sql, array()));
    }

    public static function purchaseDomain($tld, $sld) {
        $data = array(
            'tld' => $tld,
            'sld' => $sld,
        );

        include_once('exenom.php');

        $enom = new ExEnom();
        return $enom->purchaseDomain($data);
    }
}

