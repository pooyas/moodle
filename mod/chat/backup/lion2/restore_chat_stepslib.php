<?php


/**
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Define all the restore steps that will be used by the restore_chat_activity_task
 */

/**
 * Structure step to restore one chat activity
 */
class restore_chat_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $userinfo = $this->get_setting_value('userinfo');

        $paths[] = new restore_path_element('chat', '/activity/chat');
        if ($userinfo) {
            $paths[] = new restore_path_element('chat_message', '/activity/chat/messages/message');
        }

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    protected function process_chat($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $data->chattime = $this->apply_date_offset($data->chattime);
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // Insert the chat record.
        $newitemid = $DB->insert_record('chat', $data);
        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

    protected function process_chat_message($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->chatid = $this->get_new_parentid('chat');
        $data->userid = $this->get_mappingid('user', $data->userid);
        $data->groupid = $this->get_mappingid('group', $data->groupid);
        $data->message = $data->message_text;
        $data->timestamp = $this->apply_date_offset($data->timestamp);

        $newitemid = $DB->insert_record('chat_messages', $data);
        $this->set_mapping('chat_message', $oldid, $newitemid); // Because of decode.
    }

    protected function after_execute() {
        // Add chat related files, no need to match by itemname (just internally handled context).
        $this->add_related_files('mod_chat', 'intro', null);
    }
}
