<?php

add_shortcode('my_purchases','aa_my_packages');
wp_enqueue_script('jquery');
wp_enqueue_script('tablesorter', plugins_url('agentassets-site-manager').'/js/tablesorter/jquery.tablesorter.min.js','','1.7.1');
wp_enqueue_script('purchases_script', plugins_url('agentassets-site-manager').'/js/general.js','','1.7.1');

echo "<h1>My Purchases</h1>";

function aa_my_packages($atts)
{
  global $wpdb;
  $user_id = get_current_user_id();

  $purchases = $wpdb->get_results("SELECT package_name, package_price, discount, total_price, purchased_date, expiry_date FROM `" . $wpdb->base_prefix . "orders` WHERE user_id = " . $user_id);
  // echo "<pre>";print_r($purchases);"</pre>";
  if ($purchases) {
    echo '<table>';
      echo '<thead>';
        echo '<tr>';
          echo '<th>Package Name</th>';
          echo '<th>Package Price</th>';
          echo '<th>Discount</th>';
          echo '<th>Total Price</th>';
          echo '<th>Purchased Date</th>';
        echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
    foreach ($purchases as $purchase) {
      echo '<tr>';
        echo '<td>'. $purchase->package_name . '</td>';
        echo '<td>$'. number_format_i18n($purchase->package_price, 2) . '</td>';
        echo '<td>$'. number_format_i18n($purchase->discount, 2) . '</td>';
        echo '<td>$'. number_format_i18n($purchase->total_price, 2) . '</td>';
        echo '<td>'. date("M-t-Y", strtotime($purchase->purchased_date)).'</td>';
      echo '</tr>';
    }
      echo '</tbody>';
    echo '</table>';
  }
}

?>
