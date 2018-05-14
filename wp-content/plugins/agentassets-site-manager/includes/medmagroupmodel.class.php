<?php

class MedmaGroupModel {
    const REGISTRATION_PAGE_POST_ID = 18;

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
    
    public static function insertRelationship($attributes) { // Added by Buddy Quaid
        $result = false;
        global $wpdb;
        if ($wpdb->insert($wpdb->prefix."aag_group_templates_relationships_table", array(
            'bp_group_id'              => $attributes['bp_group_id_input'], //was 'name'
            'template_cat_id'   => $attributes['template_cat_input'], // was 'primaryadmin_id'
        ), array(
                '%d',
                '%d',
            )
        )) {
            $result = true;
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
    
    public static function touchRelationship() {
        return (object)array(
            'bp_group_id_input' => null,
            'template_cat_input' => null,
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

        if (strlen($attributes['name']) < 2) {
            $errors['name'] = 'The group name must have minimum 2 symbols.';
        }
        if (empty($attributes['name'])) {
            $errors['name'] = 'The group name can\'t be empty.';
        }
        $group->name = $attributes['name'];
        $group->id = isset($attributes['id']) ? $attributes['id'] : null;

        return $group;
    }
    
    public static function validateRelationship($attributes, &$errors) {
        $relationship = self::touchRelationship();
        if (empty($attributes['bp_group_id_input'])) {
            $errors['bp_group_id_input'] = 'You must select a group!';
        }
        if (empty($attributes['template_cat_input'])) {
            $errors['template_cat_input'] = 'You must select a category template!';
        }
        $relationship->bp_group_id_input = $attributes['bp_group_id_input'];
        $relationship->template_cat_input = $attributes['template_cat_input'];

        return $relationship;
    }

    public static function deleteAll($group_ids) {
        global $wpdb;
        $wpdb->query('DELETE FROM `'.$wpdb->base_prefix. 'medma_group_user`'
            .' WHERE group_id IN ('.implode(', ', $group_ids). ')');
        $wpdb->query('DELETE FROM `'.$wpdb->base_prefix. 'medma_group_theme`'
            .' WHERE group_id IN ('.implode(', ', $group_ids). ')');
        return $wpdb->query('DELETE FROM '.self::tableName()
            .' WHERE id IN ('.implode(', ', $group_ids). ')');
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
                    'name'  => $user->display_name,
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

    public static function removeRelatedUsers($group_id, $user_ids) {
        global $wpdb;
        return $wpdb->query('DELETE FROM `'.$wpdb->base_prefix. 'medma_group_user`'
            .'WHERE group_id = '.(int)$group_id.' AND user_id IN ('.implode(', ', $user_ids). ')');
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

    public static function removeRelationship($id) {
        global $wpdb;
        return $wpdb->query('DELETE FROM '.$wpdb->base_prefix. 'aag_group_templates_relationships_table WHERE id = '.$id);
    }

    public static function getAdminGroups($user_id) {
        $admin_groups = array();
        $primary_admin_groups_result = MedmaGroupModel::findAll('primaryadmin_id = %d', array($user_id));
        foreach($primary_admin_groups_result as $group) {
            $admin_groups[$group->id] = $group;
        }

        global $wpdb;
        $admin_groups_result = $wpdb->get_results('SELECT * FROM `'.MedmaGroupModel::tableName() . '` mg'
            .' INNER JOIN `'.$wpdb->base_prefix.'medma_group_user` mgu ON mg.id = mgu.group_id AND'
            .' mgu.user_id = ' . $user_id . ' AND mgu.is_admin = 1');

        foreach($admin_groups_result as $group) {
            $admin_groups[$group->id] = $group;
        }

        return $admin_groups;
    }

    public static function generateCode($seed = 0) {
        $code = md5(time() - ($seed * 5));
        $code[4] = '-';
        $code[9] = '-';

        return substr($code,0 ,16);
    }

    public static function sendInvitation($email, $code, $group_name) {
        $link = MedmaGroupModel::getCodeLink($code);
        return wp_mail($email, 'Group Invitation', 'Greetings! You have been invited to join the "'.$group_name.'" group on agentassets.com.<br/>'
            .'Please follow the link to register and enjoy the group\'s features in your site creation:<br/>'
            .'<a href="'.$link.'">'.$link.'</a>');
    }

    public static function getCodeLink($code) {
        return add_query_arg('group_code', $code, get_permalink(self::REGISTRATION_PAGE_POST_ID));
    }

    public static function addRelatedUserByCode($user_id, $code) {
        $status = false;
        $group = self::findOne('code = %s', array($code));
        if ($group) {
            $status = self::addRelatedUser($group->id, $user_id);
        }
        return $status;
    }

    public static function updateAdminRights($group_id, $user_ids, $is_admin) {
        $result = false;
        global $wpdb;
        $result = $wpdb->query('UPDATE `'.$wpdb->base_prefix.'medma_group_user` SET is_admin = '.(int)$is_admin .' '
            .' WHERE group_id = '.(int)$group_id . ' AND user_id IN('.implode(', ',$user_ids).')');

        return $result;
    }

    public static function hasAdminRights($group_id, $user_id) {
        $status = false;

        $group = self::findOne('id = '.(int)$group_id);
        if ($group->primaryadmin_id == $user_id) {
            $status = true;
        } else {
            global $wpdb;
            $result = $wpdb->get_var('SELECT is_admin FROM `'.$wpdb->base_prefix . 'medma_group_user` '
                . ' WHERE user_id = '.(int)$user_id.' AND group_id = '.(int)$group_id);
            $status = (1 == $result);
        }

        return $status;
    }
    
    public static function get_group_template_relationship() {
      global $wpdb;
      $groupsTbl       = $wpdb->prefix . 'bp_groups';
      $templatesTbl    = $wpdb->prefix . 'nbt_templates_categories';
      $relationshipTbl = $wpdb->prefix . 'aag_group_templates_relationships_table';
      
      $query  = 'SELECT '.$groupsTbl.'.name as groupName, '.$templatesTbl.'.name as templateName, '.$relationshipTbl.'.id as rowID FROM ' . $relationshipTbl;
      $query .= ' INNER JOIN '.$groupsTbl.' ON '.$relationshipTbl.'.bp_group_id = ' . $groupsTbl.'.id';
      $query .= ' INNER JOIN '.$templatesTbl.' ON '.$relationshipTbl.'.template_cat_id = ' . $templatesTbl . '.ID';
      // write_log($query);
      $results = $wpdb->get_results($query);

      return $results;
    }
}