<?php
$user = new stdClass();
$user->ID = "585";
$user->user_login = "buddyq";
$user->user_url="http://www.google.com";
$user->user_registered = "Aug-16-2016";
$user->display_name = "Jesus Christ";
$user->user_email = "buddy@buddyquaid.com";
$user->password = "something";


echo dirname(dirname(__FILE__)).'/aa-email-template.php';

$users_info = array("ID","user_login","user_email","user_url","user_registered","display_name");

$email_body = '<table>';
foreach ($user as $key => $value) {
                        if (in_array($key, $users_info)) {
$email_body .= '
                                          <tr>
                                            <td>'.$key.'</td>
  <td>'.$value.'</td>
                                          </tr>';
                        }
}
$email_body .= '</table>';

echo $email_body;
?>
