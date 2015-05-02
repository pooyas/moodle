<?php

/**
 * This file defines an adhoc task to send notifications.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

namespace tool_monitor;

defined('LION_INTERNAL') || die();

/**
 * Adhock class, used to send notifications to users.
 *
 * @since      Lion 2.8
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */
class notification_task extends \core\task\adhoc_task {

    /**
     * Send out messages.
     */
    public function execute() {
        foreach ($this->get_custom_data() as $data) {
            $eventobj = $data->event;
            $subscriptionids = $data->subscriptionids;
            foreach ($subscriptionids as $id) {
                if ($message = $this->generate_message($id, $eventobj)) {
                    mtrace("Sending message to the user with id " . $message->userto->id . " for the subscription with id $id...");
                    message_send($message);
                    mtrace("Sent.");
                }
            }
        }
    }

    /**
     * Generates the message object for a give subscription and event.
     *
     * @param int $subscriptionid Subscription instance
     * @param \stdClass $eventobj Event data
     *
     * @return false|\stdClass message object
     */
    protected function generate_message($subscriptionid, \stdClass $eventobj) {

        try {
            $subscription = subscription_manager::get_subscription($subscriptionid);
        } catch (\dml_exception $e) {
            // Race condition, someone deleted the subscription.
            return false;
        }
        $user = \core_user::get_user($subscription->userid);
        if (empty($user)) {
            // User doesn't exist. Should never happen, nothing to do return.
            return false;
        }
        $context = \context_user::instance($user->id, IGNORE_MISSING);
        if ($context === false) {
            // User context doesn't exist. Should never happen, nothing to do return.
            return false;
        }

        $template = $subscription->template;
        $template = $this->replace_placeholders($template, $subscription, $eventobj, $context);
        $msgdata = new \stdClass();
        $msgdata->component         = 'tool_monitor'; // Your component name.
        $msgdata->name              = 'notification'; // This is the message name from messages.php.
        $msgdata->userfrom          = \core_user::get_noreply_user();
        $msgdata->userto            = $user;
        $msgdata->subject           = $subscription->get_name($context);
        $msgdata->fullmessage       = format_text($template, $subscription->templateformat, array('context' => $context));
        $msgdata->fullmessageformat = $subscription->templateformat;
        $msgdata->fullmessagehtml   = format_text($template, $subscription->templateformat, array('context' => $context));
        $msgdata->smallmessage      = '';
        $msgdata->notification      = 1; // This is only set to 0 for personal messages between users.

        return $msgdata;
    }

    /**
     * Replace place holders in the template with respective content.
     *
     * @param string $template Message template.
     * @param subscription $subscription subscription instance
     * @param \stdclass $eventobj Event data
     * @param \context $context context object
     *
     * @return mixed final template string.
     */
    protected function replace_placeholders($template, subscription $subscription, $eventobj, $context) {
        $template = str_replace('{link}', $eventobj->link, $template);
        if ($eventobj->contextlevel == CONTEXT_MODULE && !empty($eventobj->contextinstanceid)
            && (strpos($template, '{modulelink}') !== false)) {
            $cm = get_fast_modinfo($eventobj->courseid)->get_cm($eventobj->contextinstanceid);
            $modulelink = $cm->url;
            $template = str_replace('{modulelink}', $modulelink, $template);
        }
        $template = str_replace('{rulename}', $subscription->get_name($context), $template);
        $template = str_replace('{description}', $subscription->get_description($context), $template);
        $template = str_replace('{eventname}', $subscription->get_event_name(), $template);

        return $template;
    }
}
