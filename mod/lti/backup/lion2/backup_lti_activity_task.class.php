<?php
//

/**
 * Defines backup_lti_activity_task class
 *
 * @package     mod
 * @subpackage lti
 * @category    backup
 * @copyright   2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/lti/backup/lion2/backup_lti_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the LTI instance
 */
class backup_lti_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the lti.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_lti_activity_structure_step('lti_structure', 'lti.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of basiclti tools.
        $search = "/(".$base."\/mod\/lti\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@LTIINDEX*$2@$', $content);

        // Link to basiclti view by moduleid.
        $search = "/(".$base."\/mod\/lti\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@LTIVIEWBYID*$2@$', $content);

        return $content;
    }
}
