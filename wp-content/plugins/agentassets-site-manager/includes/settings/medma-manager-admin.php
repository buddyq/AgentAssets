<?php

add_action('admin_menu', 'aag_theme_manager_menu');

function aag_theme_manager_menu() {
    if (is_super_admin() && get_current_blog_id() == 1) {
        add_menu_page('AgentAssets Settings', 'Assign Templates', 'aag_manager', 'aa-assign-templates', 'aag_manager_template_admin');

        // add_submenu_page('aag-manager-group-handle', 'Groups', 'Groups', 'aag_manager', 'aag-manager-group-handle', 'aag_manager_group_admin');
        // add_submenu_page('aag-manager-group-handle', 'Themes', 'Themes', 'aag_manager', 'aag-manager-theme-handle', 'aag_manager_theme_admin');
        add_submenu_page('aag-manager-group-handle', 'Assign Templates', 'Assign Templates', 'aag_manager', 'aag-manager-template-handle', 'aag_manager_template_admin');

    }
}

/*
function aag_manager_theme_admin() {
    $notices = array();
    if (isset($_POST['changeit'])) {
        $new_status = (int)(empty($_POST['new_status']) ? $_POST['new_status2'] : $_POST['new_status']);
        $update_status = MedmaThemeManager::update(array('status' => $new_status), '', $_POST['themes']);
        if ($update_status) {
            $notices[] = array('class' => 'success', 'message' => 'Themes has been successfully updated.');
        } else {
            $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t update themes.');
        }
    }


    $themes = MedmaThemeManager::buildThemesList();
    ?>
    <div class="wrap">
        <h1>Agentassets Themes Manager</h1>
        <?php if (count($notices)) foreach ($notices as $notice) { ?>
        <div class="notice notice-<?php echo $notice['class'];?> is-dismissible">
            <p><?php echo $notice['message']; ?></p>
        </div>
        <?php } ?>
        <form method="post">
            <div class="tablenav top">
                <div class="alignleft actions">
                    <label class="screen-reader-text" for="new_status">Change status to…</label>
                    <select id="new_status" name="new_status">
                        <option value="">Change status to…</option>
                        <?php foreach (MedmaThemeManager::getStatusLabels() as $value => $label) { ?>
                            <option value="<?php echo $value;?>"><?php echo $label;?></option>
                        <?php } ?>
                    </select>
                    <input id="changeit" class="button" type="submit" value="Change" name="changeit">
                </div>
                <br class="clear"/>
            </div>
            <table class="wp-list-table widefat fixed striped themes">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                            <input id="cb-select-all-1" type="checkbox">
                        </td>
                        <th class="manage-column column-name">Name</th>
                        <th class="manage-column column-system-id">System ID</th>
                        <th class="manage-column column-status">Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($themes as $theme) { ?>
                    <tr id="theme-<?php echo $theme->id;?>">
                        <th class="check-column" scope="row">
                            <label class="screen-reader-text" for="theme_<?php echo $theme->id;?>">Select <?php echo $theme->name;?></label>
                            <input id="theme_<?php echo $theme->id;?>" class="" type="checkbox" value="<?php echo $theme->id;?>" name="themes[]">
                        </th>
                        <td><?php echo $theme->name;?></td>
                        <td><?php echo $theme->theme_system_id;?></td>
                        <td><?php echo MedmaThemeManager::getStatusLabel($theme->status);?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="manage-column column-cb check-column">
                            <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                            <input id="cb-select-all-2" type="checkbox">
                        </td>
                        <th class="manage-column column-name">Name</th>
                        <th class="manage-column column-system-id">System ID</th>
                        <th class="manage-column column-status">Status</th>
                    </tr>
                </tfoot>
            </table>
            <div class="tablenav bottom">
                <div class="alignleft actions">
                    <label class="screen-reader-text" for="new_status">Change status to…</label>
                    <select id="new_status2" name="new_status2">
                        <option value="">Change status to…</option>
                        <?php foreach (MedmaThemeManager::getStatusLabels() as $value => $label) { ?>
                            <option value="<?php echo $value;?>"><?php echo $label;?></option>
                        <?php } ?>
                    </select>
                    <input id="changeit" class="button" type="submit" value="Change" name="changeit">
                </div>
                <br class="clear"/>
            </div>
        </form>
    </div>
    <?php
}
*/


function aag_manager_group_admin() {
    global $pagenow, $plugin_page;
    $this_page_url = add_query_arg( 'page', $plugin_page, admin_url( $pagenow ) );

    $notices = array();
    $view = 'list_view';
    $viewData = array();
    $currentAction = empty($_GET['medma_group_action']) ? 'list' : $_GET['medma_group_action'];
    write_log("Group Admin: ".$_GET['row_id']);
    // controller
    switch ($currentAction) {
        case 'editor' :
            $errors = array();
            $group = null;
            
            if (isset($_GET['group_id'])) {
                $group = MedmaGroupModel::findOne('id = %d', array($_GET['group_id']));
                if (false === $group) {
                    $group = null;
                }
            }
            
            if (isset($_POST['MedmaGroup'])) {
                $group = MedmaGroupModel::validate($_POST['MedmaGroup'], $errors);
                if (!count($errors)) {
                    if (empty($group->id)) {
                        $result = MedmaGroupModel::insert(get_object_vars($group));
                        if ($result) {
                            $group->id = $result;
                            $notices[] = array('class' => 'success', 'message' => 'Group has been successfully saved.');
                        } else {
                            $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t save group.');
                        }
                    } else {
                        $data = get_object_vars($group);
                        unset($data['id']);
                        $result = MedmaGroupModel::update($data, 'id = '.$group->id);
                        if (false === $result) {
                            $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t save group.');
                        } else {
                            $notices[] = array('class' => 'success', 'message' => 'Group has been successfully saved.');
                        }
                    }
                } else {
                    foreach($errors as $error) {
                        $notices[] = array('class' => 'error', 'message' => $error);
                    }
                }
            } else if (is_null($group)) {
                $group = MedmaGroupModel::touch();
                $group->code = MedmaGroupModel::generateCode();
            }

            $view = 'form_view';
            $viewData = array(
                'group' => $group,
                'errors' => $errors,
            );
            break;
            
        case 'view' :
            $group = null;
            if (isset($_GET['row_id'])) {
              write_log($_GET['row_id']);
                $view = 'view';
                $group = MedmaGroupModel::removeRelationship($_GET['row_id']);
                // $group = MedmaGroupModel::findOne('id = %d', array($_GET['row_id']));
                if (false === $group) {
                    $group = null;
                } else {
                    $subview = (isset($_GET['subview']) && 'themes' == $_GET['subview']) ? 'themes' : 'users';
                    $list = array();
                    if ($subview == 'users') {
                        if (isset($_POST['new_group_user']) && 0 < $_POST['new_group_user']) {
                            if (MedmaGroupModel::addRelatedUser($group->id, $_POST['new_group_user'])) {
                                $notices[] = array('class' => 'success', 'message' => 'New user has been successfully append to group.');
                            } else {
                                $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t append user to group.');
                            }
                        } else if (isset($_POST['bulk_action'])) {
                            if ('delete' == $_POST['bulk_action']) {
                                $ids = $_POST['group_users'];
                                $result = MedmaGroupModel::removeRelatedUsers($group->id, $ids);
                                if ($result) {
                                    $notices[] = array('class' => 'success', 'message' => 'The users has been successfully deleted.');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t delete users.');
                                }
                            } else if ('giveRights' == $_POST['bulk_action']) {
                                $ids = $_POST['group_users'];
                                $result = MedmaGroupModel::updateAdminRights($group->id, $ids, 1);
                                if ($result) {
                                    $notices[] = array('class' => 'success', 'message' => 'Success');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error');
                                }
                            } else if ('disableRights' == $_POST['bulk_action']) {
                                $ids = $_POST['group_users'];
                                $result = MedmaGroupModel::updateAdminRights($group->id, $ids, 0);
                                if ($result) {
                                    $notices[] = array('class' => 'success', 'message' => 'Success');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error');
                                }
                            }
                        }

                        $list = MedmaGroupModel::getRelatedUsers($group->id);
                    }
                    if ($subview == 'themes') {
                        if (isset($_POST['new_group_theme']) && 0 < $_POST['new_group_theme']) {
                            if (MedmaGroupModel::addRelatedTheme($group->id, $_POST['new_group_theme'])) {
                                $notices[] = array('class' => 'success', 'message' => 'New theme has been successfully append to group.');
                            } else {
                                $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t append theme to group.');
                            }
                        } else if (isset($_POST['bulk_action'])) {
                            if ('delete' == $_POST['bulk_action']) {
                                $ids = $_POST['group_themes'];
                                write_log($ids);
                                // echo "<pre>";print_r($ids);"</pre>";
                                break;
                                $result = MedmaGroupModel::removeRelationship($id);
                                if ($result) {
                                    $notices[] = array('class' => 'success', 'message' => 'The themes has been successfully deleted.');
                                } else {
                                    $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t delete themes.');
                                }
                            }
                        }
                        $list = MedmaGroupModel::getRelatedThemes($group->id);
                    }

                    $view = 'view';
                    $viewData = array(
                        'group' => $group,
                        'subview' => $subview,
                        'list' => $list,
                    );
                }
            }
            if (empty($group)) {
                $group = MedmaGroupModel::touch();
                $group->code = MedmaGroupModel::generateCode();
                $notices[] = array('class' => 'error', 'message' => 'Error! Unknown group.');
                $viewData['groups'] = MedmaGroupModel::findAll();
            }
            break;
        case 'list':
            if (isset($_POST['bulk_action'])) {
                switch ($_POST['bulk_action']) {
                    case 'delete':
                        if (isset($_POST['groups']) && is_array($_POST['$groups'])) {
                            if (MedmaGroupModel::deleteAll($_POST['$groups'])) {
                                $notices[] = array('class' => 'success', 'message' => 'The groups has been successfully removed.');
                            }
                        }
                        break;
                    case 'update_code':
                        if (isset($_POST['groups']) && is_array($_POST['groups'])) {
                            foreach($_POST['groups'] as $seed => $group_id) {
                                MedmaGroupModel::update(array(
                                    'code' => MedmaGroupModel::generateCode($seed),
                                ), ' id = '.(int)$group_id);
                            }
                            $notices[] = array('class' => 'success', 'message' => 'The group codes has been successfully updated.');
                        }
                        break;
                    default:
                        $notices[] = array('class' => 'error', 'message' => 'Error! Unknown action.');
                }
            }
            $viewData['groups'] = MedmaGroupModel::findAll();
            
            break;
        case 'remove':
            if (isset($_GET['group_id'])) {
                if (MedmaGroupModel::deleteAll(array((int)$_GET['group_id']))) {
                    $notices[] = array('class' => 'success', 'message' => 'The group has been successfully removed.');
                }
            }
            $viewData['groups'] = MedmaGroupModel::findAll();
            break;
        default:
            $notices[] = array('class' => 'error', 'message' => 'Error! Unknown action.');
            $viewData['groups'] = MedmaGroupModel::findAll();
    }

// view

?>
    <div class="wrap">
        <h1>
            Agentassets Groups Manager
            <?php if ('list_view' === $view) { ?>
            <a class="page-title-action" href="<?php echo add_query_arg('medma_group_action', 'editor', $this_page_url);?>">Add New</a>
            <?php } ?>
        </h1>
        <?php if (count($notices)) foreach ($notices as $notice) { ?>
            <div class="notice notice-<?php echo $notice['class'];?> is-dismissible">
                <p><?php echo $notice['message']; ?></p>
            </div>
        <?php }
        call_user_func('aag_manager_group_'.$view, $viewData);
        ?>
    </div>
    <?php
}

function aag_manager_template_admin() { // Added by Buddy Quaid
  global $pagenow, $plugin_page;
  $this_page_url = add_query_arg( 'page', $plugin_page, admin_url( $pagenow ) );

  $notices = array();
  $view = 'list_view';
  $viewData = array();
  $currentAction = empty($_GET['medma_group_action']) ? 'list' : $_GET['medma_group_action'];

  // controller
  switch ($currentAction) {
      case 'editor' :
          $errors = array();
          $group = null;
          
          if (isset($_GET['template_id'])) {
              $group = MedmaGroupModel::findOne('id = %d', array($_GET['template_id']));
              if (false === $group) {
                  $group = null;
              }
          }
          
          if (isset($_POST['addRelationship'])) {
            write_log(__LINE__);
              $relationship = MedmaGroupModel::validateRelationship($_POST, $errors);
              if (!count($errors)) {
                  if (empty($relationship->result)) {
                      $result = MedmaGroupModel::insertRelationship(get_object_vars($relationship));
                      if ($result) {
                          $relationship->result = $result;
                          $notices[] = array('class' => 'success', 'message' => 'Relationship has been successfully saved.');
                      } else {
                          $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t save relationship.');
                      }
                  } else {
                      $data = get_object_vars($relationship);
                      unset($data['id']);
                      $result = MedmaGroupModel::update($data, 'id = '.$relationship->id);
                      if (false === $result) {
                          $notices[] = array('class' => 'error', 'message' => 'Error! Can\'t save relationship.');
                      } else {
                          $notices[] = array('class' => 'success', 'message' => 'Relationship has been successfully saved.');
                      }
                  }
              } else {
                  foreach($errors as $error) {
                      $notices[] = array('class' => 'error', 'message' => $error);
                  }
              }
          } else if (is_null($relationship)) {
              $relationship = MedmaGroupModel::touchRelationship();
          }

          $view = 'form_view';
          $viewData = array(
              'relationship' => $relationship, // used to be 'group'
              'errors' => $errors,
          );
          break;
          
      case 'view' :
          $template = null;
          if (isset($_GET['template_id'])) {
              $view = 'view';
              $query = "SELECT * FROM ". $wpdb->prefix."aag_group_templates_relationships_table WHERE bp_group_id = ". $template_cat_id;
              $group = MedmaGroupModel::findOne('id = %d', array($_GET['template_id']));
              if (false === $group) {
                  $group = null;
              } else {
                  $list = array();

                  $view = 'view';
                  $viewData = array(
                      'group' => $group,
                      'list' => $list,
                  );
              }
          }
          if (empty($group)) {
              $group = MedmaGroupModel::touch();
              $group->code = MedmaGroupModel::generateCode();
              $notices[] = array('class' => 'error', 'message' => 'Error! Unknown group.');
              $viewData['groups'] = MedmaGroupModel::findAll();
          }
          break;
      case 'list': 
          if (isset($_GET['row_id'])) {
            $result = MedmaGroupModel::removeRelationship($_GET['row_id']);
            if($result)
            {
              $notices[] = array('class' => 'success', 'message' => 'The relationship has been successfully removed.');
            }else{
              $notices[] = array('class' => 'error', 'message' => 'Error! Unalbe to delete the relationship.');
            }
          }
          if (isset($_POST['bulk_action'])) {
              switch ($_POST['bulk_action']) {
                  case 'delete':
                      if (isset($_POST['groups']) && is_array($_POST['$groups'])) {
                          if (MedmaGroupModel::deleteAll($_POST['$groups'])) {
                              $notices[] = array('class' => 'success', 'message' => 'The groups has been successfully removed.');
                          }
                      }
                      break;
                  case 'update_code':
                      if (isset($_POST['groups']) && is_array($_POST['groups'])) {
                          foreach($_POST['groups'] as $seed => $group_id) {
                              MedmaGroupModel::update(array(
                                  'code' => MedmaGroupModel::generateCode($seed),
                              ), ' id = '.(int)$group_id);
                          }
                          $notices[] = array('class' => 'success', 'message' => 'The group codes has been successfully updated.');
                      }
                      break;
                  default:
                      $notices[] = array('class' => 'error', 'message' => 'Error! Unknown action.');
              }
          }
          // echo "<pre>";print_r(get_class_methods(AgentAssets));"</pre>";
          $viewData['relationships'] = MedmaGroupModel::get_group_template_relationship();
          break;
      case 'remove':
          if (isset($_GET['template_id'])) {
              if (MedmaGroupModel::deleteAll(array((int)$_GET['template_id']))) {
                  $notices[] = array('class' => 'success', 'message' => 'The relationship has been successfully removed.');
              }
          }
          $viewData['groups'] = MedmaGroupModel::findAll();
          break;
      default:
          $notices[] = array('class' => 'error', 'message' => 'Error! Unknown action.');
          $viewData['groups'] = MedmaGroupModel::findAll();
    }  
  ?>
  <div class="wrap">
      <h1>
          Assign - Group/Templates Relationship
          <?php if ('list_view' === $view) { ?>
          <a class="page-title-action" href="<?php echo add_query_arg('medma_group_action', 'editor', $this_page_url);?>">Assign New Relationship</a>
          <?php } ?>
      </h1>
      <?php if (count($notices)) foreach ($notices as $notice) { ?>
          <div class="notice notice-<?php echo $notice['class'];?> is-dismissible">
              <p><?php echo $notice['message']; ?></p>
          </div>
      <?php }
      call_user_func('aag_manager_template_'.$view, $viewData);
      ?>
  </div>
  <?php
}

function aag_manager_group_list_view($data) {
    global $pagenow, $plugin_page;
    $this_page_url = add_query_arg( 'page', $plugin_page, admin_url( $pagenow ) );
    $edit_action_url = add_query_arg('medma_group_action', 'editor', $this_page_url);
    $view_action_url = add_query_arg('medma_group_action', 'view', $this_page_url);
    $remove_action_url = add_query_arg('medma_group_action', 'remove', $this_page_url);
    ?>
    <form method="post">
        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="new-group-theme" name="bulk_action">
                    <option value="">Bulk Action…</option>
                    <option value="delete">Delete</option>
                    <option value="update_code">Update Code</option>
                </select>
                <input id="bulkaction" class="button" type="submit" value="Apply" name="bulkaction">
            </div>
        </div>
        <table class="wp-list-table widefat fixed striped groups">
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <th class="manage-column column-name">Name</th>
                <th class="manage-column column-primary-admin">Primary Admin</th>
                <th class="manage-column column-code">Code</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['groups'] as $group) { ?>
                <tr id="group-<?php echo $group->id;?>">
                    <th class="check-column" scope="row">
                        <label class="screen-reader-text" for="group_<?php echo $group->id;?>">Select <?php echo $group->name;?></label>
                        <input id="group_<?php echo $group->id;?>" class="" type="checkbox" value="<?php echo $group->id;?>" name="groups[]">
                    </th>
                    <td class="has-row-actions column-primary">
                        <strong><a href="<?php echo add_query_arg('group_id', $group->id, $view_action_url);?>"><?php echo $group->name;?></a></strong>
                        <br/>
                        <div class="row-actions">
                            <span class="view"><a href="<?php echo add_query_arg('group_id', $group->id, $view_action_url);?>">View</a> | </span>
                            <span class="edit"><a href="<?php echo add_query_arg('group_id', $group->id, $edit_action_url);?>">Edit</a> | </span>
                            <span class="remove"><a href="<?php echo add_query_arg('group_id', $group->id, $remove_action_url);?>">Remove</a></span>
                        </div>
                    </td>
                    <td><?php
                        $user = get_userdata($group->primaryadmin_id);
                        echo $user->user_login . ' ['.$user->user_email.']';
                        ?>
                    </td>
                    <td><?php echo $group->code;?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                    <input id="cb-select-all-2" type="checkbox">
                </td>
                <th class="manage-column column-name">Name</th>
                <th class="manage-column column-primary-admin">Primary Admin</th>
                <th class="manage-column column-code">Code</th>
            </tr>
            </tfoot>
        </table>
    </form>
    <?php
}

function aag_manager_group_form_view($data) {
    $group = $data['group'];

    if (empty($group->id)) {
    ?>
    <h2>Create New Group</h2>
    <?php } else { ?>
    <h2>Edit Group - <?php echo $group->name; ?></h2>
    <?php } ?>
    <form id="edit-group" method="post">
        <input type="hidden" name="MedmaGroup[id]" value="<?php echo $group->id;?>">
        <table class="form-table">
            <tbody>
                <?php $error = isset($data['errors']['name']) ? $data['errors']['name'] : null; ?>
                <tr class="form-field form-required <?php echo empty($error) ? '': 'form-invalid';?>">
                    <th scope="row">
                        <label for="medma-group-name">Group Name</label>
                    </th>
                    <td>
                        <input id="medma-group-name" class="" type="text" value="<?php echo $group->name;?>" name="MedmaGroup[name]" autocomplete="off"/>
                    </td>
                </tr>
                <?php $error = isset($data['errors']['primaryadmin_id']) ? $data['errors']['primaryadmin_id'] : null; ?>
                <tr class="form-field form-required <?php echo empty($error) ? '': 'form-invalid';?>">
                    <th scope="row">
                        <label for="medma-group-primaryadmin-id">Primary Admin</label>
                    </th>
                    <td>
                        <?php
                        wp_dropdown_users(array(
                            'selected' => $group->primaryadmin_id,
                            'name' => 'MedmaGroup[primaryadmin_id]',
                            'id' => 'medma-group-primaryadmin-id',
                            'multi' => true,
                            'blog_id' => '',
                        ));
                        ?>
                    </td>
                </tr>
                <?php $error = isset($data['errors']['code']) ? $data['errors']['code'] : null; ?>
                <tr class="<?php echo empty($error) ? '': 'form-invalid';?>">
                    <th scope="row">
                        <label for="medma-group-code">Code</label>
                    </th>
                    <td>
                        <input type="hidden" name="MedmaGroup[code]" value="<?php echo $group->code;?>">
                        <strong><?php echo $group->code;?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input id="groupsub" class="button button-primary" type="submit" value="Save Group">
        </p>
    </form>
    <?php
}

function aag_manager_group_view($data) {
    global $pagenow, $plugin_page;
    $this_page_url = add_query_arg( 'page', $plugin_page, admin_url( $pagenow ) );
    $group_page_url = add_query_arg( 'group_id', $data['group']->id, $this_page_url);
    $view_action_url = add_query_arg('medma_group_action', 'view', $group_page_url);
    if (isset($_GET['subview'])) {
        $view_action_url = add_query_arg('subview', $_GET['subview'], $view_action_url);
    }
    $edit_action_url = add_query_arg('medma_group_action', 'editor', $group_page_url);

    $group = $data['group'];

    $subview = isset($data['subview']) ? $data['subview'] : 'users';
    ?>
    <h2>View Group - <?php echo $group->name; ?></h2>
    <table class="wp-list-table widefat fixed striped group">
        <tr><td>Primary Admin</td>
            <td>
                <?php
                $user = get_userdata($group->primaryadmin_id);
                echo $user->user_login . ' ['.$user->user_email.']';
                ?>
            </td>
        </tr>
        <tr><td>Code</td><td><strong><?php echo $group->code;?></strong></td></tr>
    </table>
    <p>
        <a href="<?php echo add_query_arg('group_id', $group->id, $edit_action_url);?>">Edit This Group</a>
    </p>
    <br/>
    
    <?php // Added by Buddy Quaid - Gets BlogTemplates table
    echo "<h2>Added by Buddy Quaid - Get Plugin/BlogTemplates table</h2>";
    // Get all groups user belongs to.

    $templates_table = new NBT_Templates_Table();
    $templates_table->prepare_items();
    $templates_table->display();
    ?>
    <h2>Group Relations</h2>
    <h2 class="nav-tab-wrapper wp-clearfix">
        <a class="nav-tab <?php echo ('users' == $subview) ? 'nav-tab-active' : '';?>" <?php
            echo ('users' == $subview) ? '' : 'href="'.add_query_arg('subview', 'users', $view_action_url).'"';
        ?>>Users</a>
        <a class="nav-tab <?php echo ('themes' == $subview) ? 'nav-tab-active' : '';?>" <?php
            echo ('themes' == $subview) ? '' : 'href="'.add_query_arg('subview', 'themes', $view_action_url).'"';
        ?>>Themes</a>
    </h2>
    <?php

    if ($subview == 'themes') {
        aag_manager_group_view_themes($data);
    } else {
        aag_manager_group_view_users($data);
    }
}

function aag_manager_group_view_users($data) {
    ?>
    <form method="post">

        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="new-group-theme" name="bulk_action">
                    <option value="">Bulk Action…</option>
                    <option value="delete">Delete</option>
                    <option value="giveRights">Give Admin Rights</option>
                    <option value="disableRights">Disable Admin Rights</option>
                </select>
                <input id="bulkaction" class="button" type="submit" value="Apply" name="bulkaction">
            </div>
            <div class="alignleft actions">
                <label class="screen-reader-text" for="new_status">Add New User</label>
                <?php
                wp_dropdown_users(array(
                    'show_option_none' => 'Add new user…',
                    'name' => 'new_group_user',
                    'id' => 'new-group-user',
                    'multi' => true,
                    'blog_id' => '',
                ));
                ?>
                <input id="addnewuser" class="button" type="submit" value="Add" name="addnewuser">
            </div>
            <br class="clear"/>
        </div>
        <table class="wp-list-table widefat fixed striped group-users">
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <th class="manage-column column-login">Login</th>
                <th class="manage-column column-email">Email</th>
                <th class="manage-column column-role">Role</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data['list'])) foreach ($data['list'] as $group_user) { ?>
                <tr id="group-user-<?php echo $group_user->id;?>">
                    <th class="check-column" scope="row">
                        <label class="screen-reader-text" for="group_user_<?php echo $group_user->id;?>">Select <?php echo $group_user->login;?></label>
                        <input id="group_user_<?php echo $group_user->id;?>" class="" type="checkbox" value="<?php echo $group_user->id;?>" name="group_users[]">
                    </th>
                    <td><?php echo $group_user->login;?></td>
                    <td><?php echo $group_user->email;?></td>
                    <td><?php echo $group_user->is_group_admin ? 'Admin' : 'Member';?></td>
                </tr>
            <?php } else { ?>
                <tr><td colspan="3">No Results.</td></tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                    <input id="cb-select-all-2" type="checkbox">
                </td>
                <th class="manage-column column-login">Login</th>
                <th class="manage-column column-email">Email</th>
                <th class="manage-column column-role">Role</th>
            </tr>
            </tfoot>
        </table>
    </form>
    <?php
}

function aag_manager_group_view_themes($data) {
    ?>
    <form method="post">

        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="new-group-theme" name="bulk_action">
                    <option value="">Bulk Action…</option>
                    <option value="delete">Delete</option>
                </select>
                <input id="bulkaction" class="button" type="submit" value="Apply" name="bulkaction">
            </div>
            <div class="alignleft actions">
                <label class="screen-reader-text" for="new-group-theme">Add New User</label>
                <select id="new-group-theme" name="new_group_theme">
                    <option value="">Add new theme…</option>
                    <?php $themes = MedmaThemeManager::buildThemesList();
                    foreach($themes as $theme) {
                        if ($theme->status != MedmaThemeManager::STATUS_AUTHORIZED) continue;
                        ?>
                        <option value="<?php echo $theme->id;?>"><?php echo $theme->name .' ['.$theme->theme_system_id.']';?></option>
                    <?php } ?>
                </select>
                <input id="addnewtheme" class="button" type="submit" value="Add" name="addnewtheme">
            </div>
            <br class="clear"/>
        </div>
        <table class="wp-list-table widefat fixed striped group-users">
            <thead>
            <tr>
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <th class="manage-column column-login">Name</th>
                <th class="manage-column column-email">System IDaa</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data['list'])) foreach ($data['list'] as $group_theme) { ?>
                <tr id="group-theme-<?php echo $group_theme->id;?>">
                    <th class="check-column" scope="row">
                        <label class="screen-reader-text" for="theme_user_<?php echo $group_theme->id;?>">Select <?php echo $group_theme->name;?></label>
                        <input id="group_theme_<?php echo $group_theme->id;?>" class="" type="checkbox" value="<?php echo $group_theme->id;?>" name="group_themes[]">
                    </th>
                    <td><?php echo $group_theme->name;?></td>
                    <td><?php echo $group_theme->theme_system_id;?></td>
                </tr>
            <?php } else { ?>
                <tr><td colspan="3">No Results.</td></tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                    <input id="cb-select-all-2" type="checkbox">
                </td>
                <th class="manage-column column-login">Name</th>
                <th class="manage-column column-email">System IDbb</th>
            </tr>
            </tfoot>
        </table>
    </form>
    <?php
}

function aag_manager_template_list_view($data) {
  // Added by Buddy Quaid
  // echo "<pre>";print_r($data);"</pre>";
  $relationship_id = $_GET['row_id'];
    ?>
    <form method="post">

        <div class="tablenav top">
            <div class="alignleft actions">
                <select id="new-group-theme" name="bulk_action">
                    <option value="">Bulk Action…</option>
                    <option value="delete">Delete</option>
                </select>
                <input id="bulkaction" class="button" type="submit" value="Apply" name="bulkaction">
            </div>
            <div class="alignleft actions">
                <label class="screen-reader-text" for="new-group-theme">Add New User</label>
            </div>
            <br class="clear"/>
        </div>
        <table class="wp-list-table widefat fixed striped group-users">
            <thead>
            <tr class="aa-admin-header">
                <td id="cb" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </td>
                <th class="manage-column column-email">BuddyPress Group</th>
                <th class="manage-column column-email">Template Category</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($data['relationships'])) foreach ($data['relationships'] as $relation) { ?>
                <tr id="group-theme-<?php echo $relation->rowID;?>">
                    <th class="check-column" scope="row">
                        <label class="screen-reader-text" for="theme_user_<?php echo $relation->rowID;?>">Select Relation</label>
                        <input id="group_theme_<?php echo $relation->rowID;?>" class="" type="checkbox" value="<?php echo $relation->rowID;?>" name="group_themes[]">
                    </th>
                    <td>
                      <?php echo $relation->groupName;?><br>
                      <a href="<?php echo $_SERVER['REQUEST_URI'] . '&row_id='.$relation->rowID;?>" title="Delete this relationship" id="delete_<?php echo $relation->rowID?>">Delete</a>
                    </td>
                    <td><?php echo $relation->templateName;?></td>
                </tr>
            <?php } else { ?>
                <tr><td colspan="3">No Results.</td></tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-2">Select All</label>
                    <input id="cb-select-all-2" type="checkbox">
                </td>
                <th class="manage-column column-email">BuddyPress Group</th>
                <th class="manage-column column-email">Template Category</th>
            </tr>
            </tfoot>
        </table>
    </form>
    <?php
}

function aag_manager_template_form_view($data) { // Added by Buddy Quaid
    
  $user_id = get_current_user_id();
  global $wpdb;
  // Get all Groups the current user is a member of - Buddy Quaid
  $group_query = "SELECT * FROM " . $wpdb->base_prefix . "bp_groups";
  $template_cats_query = "SELECT * FROM " . $wpdb->base_prefix . "nbt_templates_categories";
  
  $groups = $wpdb->get_results($group_query, ARRAY_A);
  $template_categories = $wpdb->get_results($template_cats_query, ARRAY_A); 
  // echo "<pre>";print_r($template_categories);"</pre>";

    if (empty($group->id)) {
    ?>
    <h2>Create New Group/Template Relationship</h2>
    <?php } else { ?>
    <h2>Edit Group/Template Relationship - <?php echo $group->name; ?></h2>
    <?php } ?>
    <form id="edit-template" method="post">
        <input type="hidden" name="addRelationship" value="<?php echo $group->id;?>">
        <table class="form-table">
            <tbody>
                <?php $error = isset($data['errors']['bp_group_id_input']) ? $data['errors']['bp_group_id_input'] : null; ?>
                <tr class="form-field form-required <?php echo empty($error) ? '': 'form-invalid';?>">
                    <th scope="row">
                        <label for="medma-group-name">Group Name</label>
                    </th>
                    <td>
                        <select id="group-name" class="" type="select" name="bp_group_id_input" autocomplete="off" style="width:50%;">
                          <option value="">Select Group</option>
                          <?php foreach ($groups as $key => $group) {
                            echo '<option value="'.$groups[$key]['id'].'">'.$groups[$key]['name'].'</option>';
                          } ?>
                        </select>
                    </td>
                </tr>
                <?php $error = isset($data['errors']['template_cat_input']) ? $data['errors']['template_cat_input'] : null; ?>
                <tr class="form-field form-required <?php echo empty($error) ? '': 'form-invalid';?>">
                    <th scope="row">
                        <label for="medma-group-primaryadmin-id">Template Categories</label>
                    </th>
                    <td>
                      <select id="templates-categories" class="" type="select" name="template_cat_input" autocomplete="off" style="width:50%;">
                        <option value="">Select Template Categories</option>
                        <?php foreach ($template_categories as $key => $value) {
                          echo '<option value="'.$template_categories[$key]['ID'].'">'.$template_categories[$key]['name'].'</option>';
                        } ?>
                      </select>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input id="groupsub" class="button button-primary" type="submit" value="Add Relationship">
        </p>
    </form>
    <?php
}