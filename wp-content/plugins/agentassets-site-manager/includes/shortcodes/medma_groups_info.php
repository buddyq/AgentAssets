<?php

add_shortcode('aa_groups_info', 'medma_groups_info_shortcode');

function medma_groups_info_shortcode(/*$atts*/) {
    //if (isset($_GET['form'])) return;
    global $wpdb;
    $groups = $wpdb->get_results('SELECT * FROM `'.MedmaGroupModel::tableName().'` mg INNER JOIN `'
        .$wpdb->base_prefix.'medma_group_user` mgu ON mg.id = mgu.group_id WHERE mgu.user_id = '.(int)get_current_user_id());

    $result = array();
    if (false !== $groups) foreach($groups as $group) {
        $result[] = $group->name;
    }
    $mygroups = "<h3>Your Groups!</h3>";
    if(count($result))
    {

      $mygroups .= "<p>You can use all the themes in a group.</p>";
      $mygroups .= "<p><strong>You belong to: <em>".implode(', ',$result)."</em></strong></p>";
    }else
    {
      $mygroups .= "<p>You do not belong to any groups, but you can still use all public themes.</p>";
    }
    return $mygroups;

    // return count($result) ? 'You belong to these groups: ' . (implode(', ',$result)).'<br/>' : '';
}
