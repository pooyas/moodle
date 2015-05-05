<?php

/**
 * Renderer for the gradebook overview report
 *
 * @package    gradereport
 * @subpackage overview
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Custom renderer for the user grade report
 *
 * To get an instance of this use the following code:
 * $renderer = $PAGE->get_renderer('gradereport_overview');
 *
 */
class gradereport_overview_renderer extends plugin_renderer_base {

    public function graded_users_selector($report, $course, $userid, $groupid, $includeall) {
        global $USER;

        $select = grade_get_graded_users_select($report, $course, $userid, $groupid, $includeall);
        $output = html_writer::tag('div', $this->output->render($select), array('id'=>'graded_users_selector'));
        $output .= html_writer::tag('p', '', array('style'=>'page-break-after: always;'));

        return $output;
    }

}
