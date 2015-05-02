<?php


/**
 * Defines backup_data_activity_task
 *
 * @package     mod_data
 * @category    backup
 * @copyright   2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/data/backup/lion2/backup_data_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Database instance
 */
class backup_data_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the data.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_data_activity_structure_step('data_structure', 'data.xml'));
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

        // Link to the list of datas
        $search="/(".$base."\/mod\/data\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@DATAINDEX*$2@$', $content);

        // Link to data view by moduleid
        $search="/(".$base."\/mod\/data\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@DATAVIEWBYID*$2@$', $content);

        /// Link to database view by databaseid
        $search="/(".$base."\/mod\/data\/view.php\?d\=)([0-9]+)/";
        $content= preg_replace($search,'$@DATAVIEWBYD*$2@$', $content);

        /// Link to one "record" of the database
        $search="/(".$base."\/mod\/data\/view.php\?d\=)([0-9]+)\&(amp;)rid\=([0-9]+)/";
        $content= preg_replace($search,'$@DATAVIEWRECORD*$2*$4@$', $content);

        return $content;
    }
}
