<?php

class MedmaHelper {
    public static function getAviaMessageBox($content, $secContent = '', $htmlOptions = array()) {
        $htmlOptions = array_merge(array(
            'color' => 'blue',
            'size' => 'large',
            'icon' => '',
            'icon_font' => 'entypo-fontello'
        ), $htmlOptions);

        $html = '<div class="avia_message_box avia-color-'.$htmlOptions['color'].' avia-size-'.$htmlOptions['size'].' avia-icon_select-yes avia-border-  avia-builder-el-1  el_after_av_notification  el_before_av_notification ">';
        $html .= '<span class="avia_message_box_title">Note</span>';
        $html .= '<div class="avia_message_box_content">';
        $html .= '<span class="avia_message_box_icon" aria-hidden="true" data-av_icon="'.$htmlOptions['icon'].'" data-av_iconfont="'.$htmlOptions['icon_font'].'"></span>';
        $html .= $content;
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    public static function getConsumedSitesMessageBox($counter_details) {
        $html = '';
        if ($counter_details->site_allowed > $counter_details->site_consumed) {
            $html .= self::getAviaMessageBox('<p>You have consumed <span class="sites-consumed">' . $counter_details->site_consumed . '</span> site(s) out of ' . $counter_details->site_allowed . ' allowed.</p>');
        } elseif ($counter_details->site_allowed == $counter_details->site_consumed) {
            global $wpdb;
            $user_ID = get_current_user_id();

            // WTF?
            $table = $wpdb->base_prefix . "orders";
            $data = array('status' => 0);
            $where = array('user_id' => $user_ID, 'status' => 1);
            $where_format = array('%d', '%d');
            $result = $wpdb->update($table, $data, $where, $format = null, $where_format);
            //
            $html .= self::getAviaMessageBox('<p>You have consumed all the sites allowed by your current package. Please <a href="/pricing/" title="View Pricing">upgrade</a> your package.</p>',
                '',
                array('color' => 'red')
            );
        }
        echo $html;
    }
}
