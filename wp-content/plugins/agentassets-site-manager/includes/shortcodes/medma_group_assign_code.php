<?php

add_shortcode('aa_group_assign_code', 'medma_group_assign_code_shortcode');

function medma_group_assign_code_shortcode() {
    if (isset($_GET['form'])) return;

    $current_user_id = get_current_user_id();
    if (!$current_user_id) return;

    $notices = array();

    if (isset($_POST['MedmaAssignGroupCode'])) {
        $postData = $_POST['MedmaAssignGroupCode'];
        if (isset($postData['action']) && 'Assign' == $postData['action']) {
            $result = MedmaGroupModel::addRelatedUserByCode($current_user_id, $postData['code']);
            if ($result) {
                $notices[] = array('class' => 'success', 'message' => 'Congratulations! You successfully joined the group.');
            } else {
                $notices[] = array('class' => 'error', 'message' => 'Sorry, there\'s an error. Either you\'re already in this group, or you\'ve entered a wrong code.');
            }
        }
    }

    ob_start();
    if (count($notices)) foreach ($notices as $notice) { ?>
        <div class="avia_message_box avia-color-<?php echo ($notice['class'] == 'error') ? 'red' : 'green';?> avia-size-large avia-builder-el-1 el_after_av_notification el_before_av_notification ">
            <span class="avia_message_box_title">Note</span>
            <div class="avia_message_box_content">
                <p><?php echo $notice['message']; ?></p>
            </div>
        </div>
    <?php } ?>

    <form id="medma_group_assign_code_form" class="micu_ajax_form el_after_av_heading avia-builder-el-last "
          novalidate="novalidate" method="post">
        <div class="av-special-heading av-special-heading-h3 meta-heading el_after_av_textblock el_before_av_contact ">
            <h3>Have a Group Access Code?</h3>
            <h6>Enter a code to join a group below.</h6>
            <fieldset>
                <p id="element_medma_code" class="first_form form_element form_element_half">
                    <input id="medma-group-assign-code" class="text_input is_empty" type="text" name="MedmaAssignGroupCode[code]"
                           placeholder="Code">
                </p>
                <p id="element_medma_assign" class="form_element form_element_half">
                    <input class="button" type="submit" data-sending-label="Processing" value="Assign"
                           name="MedmaAssignGroupCode[action]">
                </p>
            </fieldset>
        </div>
    </form>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
