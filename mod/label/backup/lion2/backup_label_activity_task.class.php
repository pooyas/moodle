<?php


/**
 * Defines backup_label_activity_task class
 *
 * @package     mod_label
 * @category    backup
 * @copyright   2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/label/backup/lion2/backup_label_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Label instance
 */
class backup_label_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the label.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_label_activity_structure_step('label_structure', 'label.xml'));
    }

    /**
     * No content encoding needed for this activity
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the same content with no changes
     */
    static public function encode_content_links($content) {
        return $content;
    }
}
