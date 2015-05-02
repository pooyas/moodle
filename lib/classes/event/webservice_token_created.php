<?php

/**
 * Web service token created event.
 *
 * @package    core
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Web service token created event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - bool auto: true if it was automatically created.
 * }
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class webservice_token_created extends base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' created a web service token for the user with id '$this->relateduserid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        if (!empty($this->other['auto'])) {
            // The token has been automatically created.
            return array(SITEID, 'webservice', 'automatically create user token', '' , 'User ID: ' . $this->relateduserid);
        }
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventwebservicetokencreated', 'webservice');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/settings.php', array('section' => 'webservicetokens'));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'external_tokens';
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->relateduserid)) {
           throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['auto'])) {
            throw new \coding_exception('The \'auto\' value must be set in other.');
        }
    }
}
