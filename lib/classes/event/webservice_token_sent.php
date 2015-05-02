<?php

/**
 * Webservice token_sent event.
 *
 * @package    core
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Webservice token sent event class.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class webservice_token_sent extends base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has been sent the web service token with id '$this->objectid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'webservice', 'sending requested user token', '' , 'User ID: ' . $this->userid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventwebservicetokensent', 'webservice');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'external_tokens';
    }
}
