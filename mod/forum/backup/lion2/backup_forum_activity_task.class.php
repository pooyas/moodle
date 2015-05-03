<?php


/**
 * Defines backup_forum_activity_task class
 *
 * @package   mod_forum
 * @category  backup
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/forum/backup/lion2/backup_forum_stepslib.php');
require_once($CFG->dirroot . '/mod/forum/backup/lion2/backup_forum_settingslib.php');

/**
 * Provides the steps to perform one complete backup of the Forum instance
 */
class backup_forum_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the forum.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_forum_activity_structure_step('forum structure', 'forum.xml'));
    }

    /**
     * Encodes URLs to the index.php, view.php and discuss.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of forums
        $search="/(".$base."\/mod\/forum\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@FORUMINDEX*$2@$', $content);

        // Link to forum view by moduleid
        $search="/(".$base."\/mod\/forum\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@FORUMVIEWBYID*$2@$', $content);

        // Link to forum view by forumid
        $search="/(".$base."\/mod\/forum\/view.php\?f\=)([0-9]+)/";
        $content= preg_replace($search, '$@FORUMVIEWBYF*$2@$', $content);

        // Link to forum discussion with parent syntax
        $search="/(".$base."\/mod\/forum\/discuss.php\?d\=)([0-9]+)\&parent\=([0-9]+)/";
        $content= preg_replace($search, '$@FORUMDISCUSSIONVIEWPARENT*$2*$3@$', $content);

        // Link to forum discussion with relative syntax
        $search="/(".$base."\/mod\/forum\/discuss.php\?d\=)([0-9]+)\#([0-9]+)/";
        $content= preg_replace($search, '$@FORUMDISCUSSIONVIEWINSIDE*$2*$3@$', $content);

        // Link to forum discussion by discussionid
        $search="/(".$base."\/mod\/forum\/discuss.php\?d\=)([0-9]+)/";
        $content= preg_replace($search, '$@FORUMDISCUSSIONVIEW*$2@$', $content);

        return $content;
    }
}
