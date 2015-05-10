<?php

/**
 * Popup message processor, stores messages to be shown using the message popup
 *
 * @package   message
 * @subpackage popup
 * @copyright 2015 Pooya Saeedi
 */

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php'); //included from messagelib (how to fix?)
require_once($CFG->dirroot.'/message/output/lib.php');

/**
 * The popup message processor
 *
 */
class message_output_popup extends message_output{

    /**
     * Process the popup message.
     * The popup doesn't send data only saves in the database for later use,
     * the popup_interface.php takes the message from the message table into
     * the message_read.
     * @param object $eventdata the event data submitted by the message sender plus $eventdata->savedmessageid
     * @return true if ok, false if error
     */
    public function send_message($eventdata) {
        global $DB;

        //hold onto the popup processor id because /admin/cron.php sends a lot of messages at once
        static $processorid = null;

        //prevent users from getting popup notifications of messages to themselves (happens with forum notifications)
        if ($eventdata->userfrom->id!=$eventdata->userto->id) {
            if (empty($processorid)) {
                $processor = $DB->get_record('message_processors', array('name'=>'popup'));
                $processorid = $processor->id;
            }
            $procmessage = new stdClass();
            $procmessage->unreadmessageid = $eventdata->savedmessageid;
            $procmessage->processorid     = $processorid;

            //save this message for later delivery
            $DB->insert_record('message_working', $procmessage);
        }

        return true;
    }

    /**
     * Creates necessary fields in the messaging config form.
     *
     * @param array $preferences An array of user preferences
     */
    function config_form($preferences) {
        return null;
    }

    /**
     * Parses the submitted form data and saves it into preferences array.
     *
     * @param stdClass $form preferences form class
     * @param array $preferences preferences array
     */
    public function process_form($form, &$preferences) {
        return true;
    }

    /**
     * Loads the config data from database to put on the form during initial form display
     *
     * @param array $preferences preferences array
     * @param int $userid the user id
     */
    public function load_data(&$preferences, $userid) {
        global $USER;
        return true;
    }
}
