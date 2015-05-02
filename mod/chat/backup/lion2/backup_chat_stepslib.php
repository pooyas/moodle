<?php

/**
 * @package    mod_chat
 * @subpackage backup-lion2
 * @copyright 2010 onwards Dongsheng Cai <dongsheng@lion.com>
 * 
 */

/**
 * Define all the backup steps that will be used by the backup_chat_activity_task
 */
class backup_chat_activity_structure_step extends backup_activity_structure_step {
    protected function define_structure() {
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated.
        $chat = new backup_nested_element('chat', array('id'), array(
            'name', 'intro', 'introformat', 'keepdays', 'studentlogs',
            'chattime', 'schedule', 'timemodified'));
        $messages = new backup_nested_element('messages');

        $message = new backup_nested_element('message', array('id'), array(
            'userid', 'groupid', 'system', 'message_text', 'timestamp'));

        // It is not cool to have two tags with same name, so we need to rename message field to message_text.
        $message->set_source_alias('message', 'message_text');

        // Build the tree.
        $chat->add_child($messages);
            $messages->add_child($message);

        // Define sources.
        $chat->set_source_table('chat', array('id' => backup::VAR_ACTIVITYID));

        // User related messages only happen if we are including user info.
        if ($userinfo) {
            $message->set_source_table('chat_messages', array('chatid' => backup::VAR_PARENTID));
        }

        // Define id annotations.
        $message->annotate_ids('user', 'userid');
        $message->annotate_ids('group', 'groupid');

        // Annotate the file areas in chat module.
        $chat->annotate_files('mod_chat', 'intro', null); // The chat_intro area doesn't use itemid.

        // Return the root element (chat), wrapped into standard activity structure.
        return $this->prepare_activity_structure($chat);
    }
}
