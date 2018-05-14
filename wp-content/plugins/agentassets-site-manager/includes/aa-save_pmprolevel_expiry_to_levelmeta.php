<?php 

/* GOAL: Add site expiration values from PMPro Level to aa_pmpro_membership_levelmeta
1) Get PMPro Level expiration values: expiration_number and expiration_period
2) Insert value into levelmeta table
Columns: meta_id | pmpro_membership_level_id | meta_key | meta_value
*/

function update_pmpro_levelmeta_tables($level){

  global $wpdb;
  
  $record_exists = 'SELECT meta_id FROM aa_pmpro_membership_levelmeta WHERE pmpro_membership_level_id = '.$level;
  $metaID = $wpdb->get_results($record_exists);
  $metaID = $metaID[0]->meta_id;
  $levels_table = 'aa_pmpro_membership_levels';
  $meta_table   = 'aa_pmpro_membership_levelmeta';
  $query  = 'SELECT expiration_number, expiration_period FROM ';
  $query .= $levels_table . ' WHERE id = ' . $level;
  $results = $wpdb->get_results($query);
  $meta_value = $results[0]->expiration_number . " ". $results[0]->expiration_period;

  $data = array(
    'meta_id' => $metaID,
    'pmpro_membership_level_id' => $level,
    'meta_key'   => 'duration',
    'meta_value' => $meta_value
  );

  $format = array(
    '%d',
    '%d',
    '%s', 
    '%s' 
  );

  $wpdb->replace( $meta_table, $data, $format );
}

add_action("pmpro_save_membership_level", "update_pmpro_levelmeta_tables");

?>