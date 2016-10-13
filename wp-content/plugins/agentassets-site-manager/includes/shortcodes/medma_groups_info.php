<?php

<<<<<<< HEAD
add_shortcode('aa_groups_info', 'aa_groups_info_shortcode');

function aa_groups_info_shortcode(/*$atts*/) {
=======
add_shortcode('aa_groups_info', 'medma_groups_info_shortcode');

function medma_groups_info_shortcode(/*$atts*/) {
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    //if (isset($_GET['form'])) return;
    global $wpdb;
    $groups = $wpdb->get_results('SELECT * FROM `'.MedmaGroupModel::tableName().'` mg INNER JOIN `'
        .$wpdb->base_prefix.'medma_group_user` mgu ON mg.id = mgu.group_id WHERE mgu.user_id = '.(int)get_current_user_id());

<<<<<<< HEAD

=======
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
    $result = array();
    if (false !== $groups) foreach($groups as $group) {
        $result[] = $group->name;
    }

<<<<<<< HEAD
    return count($result) ? (implode(', ',$result)) : 'You don\'t belong to any groups! :)';
}
=======
    return count($result) ? 'You are a member of following groups: ' . (implode(', ',$result)).'<br/>' : '';
}
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6
