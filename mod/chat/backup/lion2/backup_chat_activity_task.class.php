<?php

/**
 * Defines backup_chat_activity_task class
 *
 * @package     mod_chat
 * @category    backup
 * @copyright   2010 onwards Dongsheng Cai <dongsheng@lion.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/chat/backup/lion2/backup_chat_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Chat instance
 */
class backup_chat_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the chat.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_chat_activity_structure_step('chat_structure', 'chat.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot . '/mod/chat', '#');

        // Link to the list of chats.
        $pattern = "#(".$base."\/index.php\?id\=)([0-9]+)#";
        $content = preg_replace($pattern, '$@CHATINDEX*$2@$', $content);

        // Link to chat view by moduleid.
        $pattern = "#(".$base."\/view.php\?id\=)([0-9]+)#";
        $content = preg_replace($pattern, '$@CHATVIEWBYID*$2@$', $content);

        return $content;
    }
}
