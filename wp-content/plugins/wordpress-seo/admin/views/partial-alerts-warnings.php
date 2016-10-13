<?php
/**
 * @package WPSEO\Admin
 */

$type = 'warnings';
$dashicon = 'flag';

<<<<<<< HEAD
$i18n_title = __( 'Notifications', 'wordpress-seo' );
$i18n_issues = '';
$i18n_no_issues = __( 'No notifications found.', 'wordpress-seo' );
=======
$i18n_title = __( 'Improvements', 'wordpress-seo' );
$i18n_issues = __( 'Implement the following suggestions to further optimize your site for SEO.', 'wordpress-seo' );
$i18n_no_issues = __( 'Good job! We found nothing you can improve upon.', 'wordpress-seo' );
>>>>>>> cbca85a547a01e619731d4a6c8e5344390fa2dc6

$active_total = count( $alerts_data['warnings']['active'] );
$total = $alerts_data['metrics']['warnings'];

$active = $alerts_data['warnings']['active'];
$dismissed = $alerts_data['warnings']['dismissed'];

include 'partial-alerts-template.php';
