<?php

class MedmaGroupModel {
    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'medma_group';
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
            'name'              => $attributes['name'],
            'primaryadmin_id'   => $attributes['primaryadmin_id'],
            'code'            => $attributes['code'],
        ), array(
                '%s',
                '%d',
                '%s',
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

    public static function touch() {
        return (object)array(
            'id' => null,
            'name' => null,
            'primaryadmin_id' => null,
            'code' => null,
        );
    }

    public static function validate($attributes, &$errors) {
        $group = self::touch();
        $group->code = isset($attributes['code']) ? $attributes['code'] : self::generateCode();

        if (empty($group->code)) {
            $errors['code'] = 'The group code can\'t be empty.';
        }
        if(false !== get_userdata($attributes['primaryadmin_id'])) {
            $group->primaryadmin_id = $attributes['primaryadmin_id'];
        } else {
            $errors['primaryadmin_id'] = 'Invalid user.';
        }

        if (strlen($attributes['name']) < 6) {
            $errors['name'] = 'The group name must have minimum 6 symbols.';
        }
        if (empty($attributes['name'])) {
            $errors['name'] = 'The group name can\'t be empty.';
        }
        $group->name = $attributes['name'];
        $group->id = isset($attributes['id']) ? $attributes['id'] : null;

        return $group;
    }

    public static function getRelatedUsers($group_id) {
        $list = array();

        global $wpdb;
        $relations = $wpdb->get_results('SELECT * FROM `'.$wpdb->base_prefix.'medma_group_user'.'` WHERE group_id = '.(int)$group_id);
        if ($relations) {
            $relationIndex = array();
            foreach ($relations as $relation) {
                $relationIndex[$relation->user_id] = $relation;
            }

            $users = get_users(array(
                'blog_id' => '',
                'include' => array_keys($relationIndex),
            ));

            foreach($users as $user) {
                $list[] = (object)array(
                    'id' => $user->ID,
                    'email' => $user->user_email,
                    'login' => $user->user_login,
                    'is_group_admin' => $relationIndex[$user->ID]->is_admin,
                );
            }
        }

        return $list;
    }

    public static function addRelatedUser($group_id, $user_id, $is_admin = 0) {
        if (false === get_userdata($user_id)) {
            return false;
        }
        global $wpdb;

        return $wpdb->insert($wpdb->base_prefix.'medma_group_user', array(
            'group_id' => $group_id,
            'user_id' => $user_id,
            'is_admin' => $is_admin,
        ));
    }

    public static function getRelatedThemes($group_id) {
        global $wpdb;

        $list = $wpdb->get_results('SELECT * FROM `'.$wpdb->base_prefix.'medma_theme` mt INNER JOIN `'
            . $wpdb->base_prefix.'medma_group_theme` mgt ON mt.id = mgt.theme_id WHERE mgt.group_id = '.(int)$group_id);

        return $list;
    }

    public static function addRelatedTheme($group_id, $theme_id) {
        global $wpdb;
        if (!$wpdb->get_var('SELECT COUNT(id) FROM `'.$wpdb->base_prefix.'medma_theme` WHERE id = '.(int)$theme_id.' LIMIT 1')) {
            return false;
        }

        return $wpdb->insert($wpdb->base_prefix.'medma_group_theme', array(
            'group_id' => $group_id,
            'theme_id' => $theme_id,
        ));
    }

    public static function generateCode() {
        $code = md5(time());
        $code[4] = '-';
        $code[9] = '-';

        return substr($code,0 ,16);
    }
}