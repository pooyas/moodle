<?php


/**
 * Defines backup_page_activity_task class
 *
 * @package   mod_page
 * @category  backup
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/page/backup/lion2/backup_page_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Page instance
 */
class backup_page_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the page.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_page_activity_structure_step('page_structure', 'page.xml'));
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

        // Link to the list of pages
        $search="/(".$base."\/mod\/page\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@PAGEINDEX*$2@$', $content);

        // Link to page view by moduleid
        $search="/(".$base."\/mod\/page\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@PAGEVIEWBYID*$2@$', $content);

        return $content;
    }
}
