<?php

add_shortcode('medma_groups_admin', 'medma_groups_admin_shortcode');

function medma_groups_admin_shortcode(/*$atts*/) {
    if (isset($_GET['form'])) return;

    $current_user_id = get_current_user_id();
    if (!$current_user_id) return;

    //global $pagenow, $plugin_page;
    //$this_page_url = add_query_arg( 'page', $plugin_page, admin_url( $pagenow ) );

    $notices = array();
    $view = 'list_view';
    $viewData = array();

    if (isset($_GET['medma_group_action'])) {
        switch ($_GET['medma_group_action']) {
            case 'view':
                if (isset($_GET['group_id']) && $group = MedmaGroupModel::findOne('id = '.(int)$_GET['group_id'])) {
                    $is_primary_admin = ($current_user_id == $group->primaryadmin_id);
                    $view = 'view';
                    $viewData = array(
                        'group' => $group,
                    );
                    if (isset($_POST['MedmaAdminGroup'])) {
                        $postData = $_POST['MedmaAdminGroup'];
                        if ('Invite' == $postData['action'] && isset($_POST['Invitation'])) {
                            $email = $_POST['Invitation']['email'];
                            $user = get_user_by('email', $email);
                            if ($user) {
                                $result = MedmaGroupModel::addRelatedUser($group->id, $user->ID);
                                if ($result) {
                                    $notices[] = array('class' => 'success', 'message' => 'The user has been successfully append to the group.');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t append user to the group.');
                                }
                            } else {
                                $result = MedmaGroupModel::sendInvitation($email, $group->code);
                                if ($result) {
                                    $notices[] = array('class' => 'success', 'message' => 'The invitation letter has been successfully sent.');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t send the invitation.');
                                }
                            }
                        } else if ('Rename' == $postData['action'] && $is_primary_admin) {
                            $error = null;
                            if (empty($postData['name'])) {
                                $error = 'The group name can\'t be empty.';
                            } else if (strlen($postData['name']) < 6) {
                                $error = 'The group name must have minimum 6 symbols.';
                            }
                            if ($error) {
                                $notices[] = array('class' => 'error', 'message' => $error);
                            } else {
                                global $wpdb;
                                $name = $wpdb->_real_escape($postData['name']);
                                $result = MedmaGroupModel::update(array('name' => $name), 'id = '.(int)$group->id );
                                if ($result) {
                                    $group->name = $name;
                                    $notices[] = array('class' => 'success', 'message' => 'The group name has been successfully updated.');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t update the group name.');
                                }
                            }
                        } else if ('Generate New' == $postData['action'] && $is_primary_admin) {
                            $newCode = MedmaGroupModel::generateCode();
                            $result = MedmaGroupModel::update(array('code' => $newCode), 'id = '.(int)$group->id );
                            if ($result) {
                                $group->code = $newCode;
                                $notices[] = array('class' => 'success', 'message' => 'The group code has been successfully updated.');
                            } else {
                                $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t update the group code.');
                            }
                        } else if ('Bar' == $postData['action']) {

                        }
                    }
                    $viewData['users'] = MedmaGroupModel::getRelatedUsers($group->id);
                    break;
                } // else goto default:
            case 'addUser':
                //todo
                break;
            default:
                $viewData['groups'] = MedmaGroupModel::getAdminGroups($current_user_id);
        }
    } else {
        $viewData['groups'] = MedmaGroupModel::getAdminGroups($current_user_id);
    }

    ob_start();
    if (count($notices)) foreach ($notices as $notice) { ?>
        <div class="avia_message_box avia-color-<?php echo ($notice['class'] == 'error') ? 'red' : 'green';?> avia-size-large avia-builder-el-1 el_after_av_notification el_before_av_notification ">
            <span class="avia_message_box_title">Note</span>
            <div class="avia_message_box_content">
                <p><?php echo $notice['message']; ?></p>
            </div>
        </div>
    <?php }
    call_user_func('medma_groups_admin_shortcode_'.$view, $viewData);
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function medma_groups_admin_shortcode_list_view($data) {
    $groups = $data['groups'];
    $this_page_url = get_permalink();
    $view_page_url = add_query_arg( 'medma_group_action', 'view', $this_page_url);
    ?>
        <div id="medma_admin_group_list" class="el_after_av_heading  avia-builder-el-last">
            <table>
                <thead>
                    <tr>
                        <th itemprop="headline" colspan="2">Group Administration</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($groups as $group) { ?>
                    <tr>
                        <td><a href="<?php echo add_query_arg('group_id', $group->id, $view_page_url);?>"><?php echo $group->name;?></a></td>
                        <td style="width: 1px;"><?php echo $group->primaryadmin_id == get_current_user_id() ? 'Primary&nbsp;Group' : '';?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
}

function medma_groups_admin_shortcode_view($data) {
    global $pagenow, $plugin_page;
    $group = $data['group'];
    $this_page_url = add_query_arg( 'page', $plugin_page, admin_url( $pagenow ) );
    $is_primary_admin = (get_current_user_id() == $group->primaryadmin_id);
    ?>
    <form id="medma_admin_group_form" class="micu_ajax_form el_after_av_heading avia-builder-el-last " novalidate="novalidate" method="post">
        <div class="av-special-heading av-special-heading-h3 meta-heading el_after_av_textblock el_before_av_contact ">
            <h3 class="av-special-heading-tag" itemprop="headline"><?php echo $group->name;?> Group Managment</h3>
            <div class="special-heading-border">
                <div class="special-heading-inner-border"></div>
            </div>

            <fieldset>
                <input type="hidden" value="<?php echo $group->id;?>" name="MedmaAdminGroup[id]" >
                <p id="element_medma_email" class="first_form form_element form_element_half">
                    <label for="medma-admin-group-email">Email for sending invite</label>
                    <input id="medma-admin-group-email" class="text_input is_empty" type="text" name="Invitation[email]"  placeholder="Email">
                </p>
                <p id="element_medma_send_invite" class="form_element form_element_half">
                    <label>&nbsp;</label>
                    <input class="button" type="submit" data-sending-label="Processing" value="Invite" name="MedmaAdminGroup[action]">
                </p>

                <?php if ($is_primary_admin) { ?>
                <p id="element_medma_name" class="first_form form_element form_element_half">
                    <label for="medma-admin-group-name">Group Name</label>
                    <input id="medma-admin-group-name" value="<?php echo htmlspecialchars($group->name);?>" class="text_input is_empty" type="text" name="MedmaAdminGroup[name]"  placeholder="Name">
                </p>
                <p id="element_medma_rename" class="form_element form_element_half">
                    <label>&nbsp;</label>
                    <input class="button" type="submit" data-sending-label="Processing" value="Rename" name="MedmaAdminGroup[action]">
                </p>
                <?php } ?>

                <p id="element_medma_code" class="first_form form_element form_element_half">
                    <label for="medma-admin-group-code">Code</label>
                    <input id="medma-admin-group-code" value="<?php echo htmlspecialchars($group->code);?>" class="text_input is_empty" type="text" name="MedmaAdminGroup[code]" readonly="readonly">
                    <span>Link for invite users: <strong><?php echo MedmaGroupModel::getCodeLink($group->code);?></strong></span>
                </p>
                <p id="element_medma_send_generate_new" class="form_element form_element_half">
                    <label>&nbsp;</label>
                    <?php if ($is_primary_admin) { ?>
                    <input class="button" type="submit" data-sending-label="Processing" value="Generate New" name="MedmaAdminGroup[action]">
                    <?php } ?>
                </p>

            </fieldset>

            <div id="medma_admin_group_list" class="el_after_av_heading  avia-builder-el-last">
                <table>
                    <thead>
                    <tr>
                        <th itemprop="headline" colspan="4">Group Users</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data['users'] as $user) { ?>
                        <tr>
                            <td><?php echo $user->name;?></td>
                            <td><?php echo $user->email;?></td>
                            <td><?php echo ($user->is_group_admin) ? 'Admin' : 'Member';?></td>
                            <td style="width: 350px;">
                                <?php if ($user->is_group_admin) { ?>
                                    <input type="submit" class="button botton-danger" value="Remove Admin Rights" name="bar_<?php echo $user->id; ?>">
                                <?php } else { ?>
                                    <input type="submit" class="button botton-danger" value="Give Admin Rights" name="bar_<?php echo $user->id; ?>">
                                <?php } ?>
                                <input type="submit" class="button botton-danger" value="Remove from Group" name="bar_<?php echo $user->id; ?>">
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <?php
}
