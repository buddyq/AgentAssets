<?php

class MedmaThemeManager {
    const STATUS_DISABLED = 0;
    const STATUS_FREE = 1;
    const STATUS_AUTHORIZED = 2;

    protected static $_themes_list_cache = null;

    public static function getStatusLabels() {
        return array(
            self::STATUS_DISABLED => 'Disabled',
            self::STATUS_FREE => 'Free',
            self::STATUS_AUTHORIZED => 'Authorized'
        );
    }

    public static function getStatusLabel($status) {
        $labels = self::getStatusLabels();
        return $labels[$status];
    }

    public static function tableName() {
        global $wpdb;
        return $wpdb->base_prefix . 'medma_theme';
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
            'theme_system_id'   => $attributes['theme_system_id'],
            'status'            => $attributes['status'],
        ), array(
                '%s',
                '%s',
                '%d',
            )
        )) {
            $result = $wpdb->insert_id;
        }
        return $result;
    }

    public static function update($attributes, $where, $theme_ids = array()) {
        global $wpdb;

        $fields = array();
        foreach ( $attributes as $field => $value ) {
            if ( isset($value['value']) && is_null( $value['value'] ) ) {
                $fields[] = "`$field` = NULL";
                continue;
            }
            $fields[] = "`$field` = " . $value;
        }
        $fields = implode( ', ', $fields );

        $theme_ids_in = (count($theme_ids)) ? 'IN ('.implode(',',$theme_ids).')' : '';

        if (!empty($theme_ids_in)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= (' id '.$theme_ids_in);
        }

        $sql = 'UPDATE `'.self::tableName().'` SET '.$fields.' WHERE '.$where;
        $result = $wpdb->query($wpdb->prepare($sql, array()));
        if ($result && isset($attributes['status']) && self::STATUS_AUTHORIZED != $attributes['status']) {
            $wpdb->query('DELETE FROM `'.$wpdb->base_prefix.'medma_group_theme` WHERE `theme_id` '.$theme_ids_in);
        }
        return $result;
    }

    public static function buildThemesList() {
        global $wpdb;

        $system_themes = array();
        $medma_themes = array();
        $medma_themes_result = self::findAll();

        // build index for db data
        foreach($medma_themes_result as $medma_theme) {
            $medma_themes[$medma_theme->theme_system_id] = $medma_theme;
        }

        // build index for system data and check themes for insert to db
        foreach (wp_get_themes() as $system_theme) {
            $theme_system_id = $system_theme->get_stylesheet();
            $system_themes[$theme_system_id] = $system_theme;
            if (!isset($medma_themes[$theme_system_id])) {
                $id = self::insert(array(
                    'name' => $system_theme->Name,
                    'theme_system_id' => $theme_system_id,
                    'status' => self::STATUS_DISABLED,
                ));
                $medma_themes[$theme_system_id] = (object)array(
                    'id' => $id,
                    'name' => $system_theme->Name,
                    'theme_system_id' => $theme_system_id,
                    'status' => self::STATUS_DISABLED,
                );
            }
        }

        // check medma themes for drop
        $delete_ids = array();
        foreach ($medma_themes as $system_id => $item) {
            if (!isset($system_themes[$system_id])) {
                $delete_ids[] = $item->id;
                unset($medma_themes[$system_id]);
            }
        }
        if (0 < count($delete_ids)) {
            $theme_ids_in = 'IN('.implode(',',$delete_ids).')';
            $wpdb->delete(self::tableName(), 'id '.$theme_ids_in);

            $wpdb->query('DELETE FROM `'.$wpdb->base_prefix.'medma_group_theme` WHERE `theme_id` IN '.$theme_ids_in);
        }

        return $medma_themes;
    }

    public static function checkAccess($theme_system_id) {
        if (is_null(self::$_themes_list_cache)) {
            self::$_themes_list_cache = self::buildThemesList();
        }

        $status = false;
        if (isset(self::$_themes_list_cache[$theme_system_id])) {
            $theme = self::$_themes_list_cache[$theme_system_id];
            if ($theme->status == self::STATUS_FREE) {
                $status = true;
            }
            if ($theme->status == self::STATUS_AUTHORIZED) {
                global $wpdb;
                $status = (0 < $wpdb->get_var('SELECT count(mg.id) FROM aa_medma_group mg '
                    . 'INNER JOIN aa_medma_group_user mgu ON mgu.group_id = mg.id '
                    . 'LEFT JOIN aa_medma_group_theme mgt ON mgt.group_id = mg.id '
                    . 'LEFT JOIN aa_medma_theme mt ON mt.id = mgt.theme_id '
                    . 'WHERE mt.theme_system_id = "'.$theme_system_id.'" AND mgu.user_id = '.(int)get_current_user_id()
                ));
            }
        }
        return $status;
    }

    public static function getThemeGroups($theme_system_id) {
        global $wpdb;
        $mg = '`'.$wpdb->base_prefix.'medma_group`';
        $mt = '`'.$wpdb->base_prefix.'medma_theme`';
        $mgt = '`'.$wpdb->base_prefix.'medma_group_theme`';

        $escaped_theme_system_id = $wpdb->_real_escape($theme_system_id);

        return $wpdb->get_results("SELECT mg.id, mg.`name` FROM $mgt mgt "
            . " INNER JOIN $mt mt ON mt.id = mgt.theme_id AND mt.theme_system_id = \"$escaped_theme_system_id\""
            . " LEFT JOIN $mg mg ON mg.id = mgt.group_id");
    }
}
