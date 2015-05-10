<?php

/**
 * This file contains the backup activity for the assign module
 *
 * @package   mod
 * @subpackage assign
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/assign/backup/lion2/backup_assign_stepslib.php');

/**
 * assign backup task that provides all the settings and steps to perform one complete backup of the activity
 *
 */
class backup_assign_activity_task extends backup_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        $this->add_step(new backup_assign_activity_structure_step('assign_structure', 'assign.xml'));
    }

    /**
     * Code the transformations to perform in the activity in
     * order to get transportable (encoded) links
     * @param string $content
     * @return string
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        $search="/(".$base."\/mod\/assign\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@ASSIGNINDEX*$2@$', $content);

        $search="/(".$base."\/mod\/assign\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@ASSIGNVIEWBYID*$2@$', $content);

        return $content;
    }

}

