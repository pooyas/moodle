<?php

/**
 * This file contains a renderer for the assignment class
 *
 * @package   assignfeedback_file
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * A custom renderer class that extends the plugin_renderer_base and is used by the assign module.
 *
 * @package assignfeedback_file
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * 
 */
class assignfeedback_file_renderer extends plugin_renderer_base {

    /**
     * Render a summary of the zip file import
     *
     * @param assignfeedback_file_import_summary $summary - Stats about the zip import
     * @return string The html response
     */
    public function render_assignfeedback_file_import_summary($summary) {
        $o = '';
        $o .= $this->container(get_string('userswithnewfeedback', 'assignfeedback_file', $summary->userswithnewfeedback));
        $o .= $this->container(get_string('filesupdated', 'assignfeedback_file', $summary->feedbackfilesupdated));
        $o .= $this->container(get_string('filesadded', 'assignfeedback_file', $summary->feedbackfilesadded));

        $url = new lion_url('view.php',
                              array('id'=>$summary->cmid,
                                    'action'=>'grading'));
        $o .= $this->continue_button($url);
        return $o;
    }
}

