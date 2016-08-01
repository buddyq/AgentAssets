<?php

add_shortcode('medma_groups_info', 'medma_groups_info_shortcode');

function medma_groups_info_shortcode(/*$atts*/) {
    //if (isset($_GET['form'])) return;
    global $wpdb;
    $groups = $wpdb->get_results('SELECT * FROM `'.MedmaGroupModel::tableName().'` mg INNER JOIN `'
        .$wpdb->base_prefix.'medma_group_user` mgu ON mg.id = mgu.group_id WHERE mgu.user_id = '.(int)get_current_user_id());

    $result = array();
    if (false !== $groups) foreach($groups as $group) {
        $result[] = $group->name;
    }

    return count($result) ? 'You are a member of following groups: ' . (implode(', ',$result)).'<br/>' : '';
}