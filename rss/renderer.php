<?php


/**
 * Web service documentation renderer.
 * @category   rss
 * @package    core
 * @subpackage rss
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Web service documentation renderer extending the plugin_renderer_base class.
 * @category   rss
 */
class core_rss_renderer extends plugin_renderer_base {
    /**
     * Returns the html for the token reset confirmation box
     * @return string html
     */
    public function user_reset_rss_token_confirmation() {
        global $OUTPUT, $CFG;
        $managetokenurl = $CFG->wwwroot."/user/managetoken.php?sesskey=" . sesskey();
        $optionsyes = array('action' => 'resetrsstoken', 'confirm' => 1, 'sesskey' => sesskey());
        $optionsno  = array('section' => 'webservicetokens', 'sesskey' => sesskey());
        $formcontinue = new single_button(new lion_url($managetokenurl, $optionsyes), get_string('reset'));
        $formcancel = new single_button(new lion_url($managetokenurl, $optionsno), get_string('cancel'), 'get');
        $html = $OUTPUT->confirm(get_string('resettokenconfirmsimple', 'webservice'), $formcontinue, $formcancel);
        return $html;
    }

    /**
     * Display a user token with buttons to reset it
     * @param string $token The token to be displayed
     * @return string html code
     */
    public function user_rss_token_box($token) {
        global $OUTPUT, $CFG;

        // Display strings.
        $stroperation = get_string('operation', 'webservice');
        $strtoken = get_string('key', 'webservice');

        $return = $OUTPUT->heading(get_string('rss'), 3, 'main', true);
        $return .= $OUTPUT->box_start('generalbox webservicestokenui');

        $return .= get_string('rsskeyshelp');

        $table = new html_table();
        $table->head  = array($strtoken, $stroperation);
        $table->align = array('left', 'center');
        $table->width = '100%';
        $table->data  = array();

        if (!empty($token)) {
            $reset = "<a href=\"".$CFG->wwwroot."/user/managetoken.php?sesskey=".sesskey().
                    "&amp;action=resetrsstoken\">".get_string('reset')."</a>";

            $table->data[] = array($token, $reset);

            $return .= html_writer::table($table);
        } else {
            $return .= get_string('notoken', 'webservice');
        }

        $return .= $OUTPUT->box_end();
        return $return;
    }
}
