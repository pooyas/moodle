<?php



/**
 * Defines backup_assignment_activity_task class
 *
 * @category    backup
 * @package    mod
 * @subpackage assignment
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot.'/mod/assignment/backup/lion2/backup_assignment_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Assignment instance
 */
class backup_assignment_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the assignment.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_assignment_activity_structure_step('assignment_structure', 'assignment.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of assignments
        $search="/(".$base."\/mod\/assignment\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@ASSIGNMENTINDEX*$2@$', $content);

        // Link to assignment view by moduleid
        $search="/(".$base."\/mod\/assignment\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@ASSIGNMENTVIEWBYID*$2@$', $content);

        return $content;
    }
}
