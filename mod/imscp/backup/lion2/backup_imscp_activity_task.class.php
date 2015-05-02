<?php

/**
 * Defines backup_imscp_activity_task class
 *
 * @package     mod_imscp
 * @category    backup
 * @copyright   2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/imscp/backup/lion2/backup_imscp_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the IMSCP instance
 *
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */
class backup_imscp_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the imscp.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_imscp_activity_structure_step('imscp_structure', 'imscp.xml'));
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

        // Link to the list of imscps.
        $search = "/(" . $base . "\/mod\/imscp\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@IMSCPINDEX*$2@$', $content);

        // Link to imscp view by moduleid.
        $search = "/(" . $base . "\/mod\/imscp\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@IMSCPVIEWBYID*$2@$', $content);

        return $content;
    }
}
