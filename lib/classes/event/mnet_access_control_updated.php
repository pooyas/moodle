<?php

/**
 * Mnet access control updated event.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Mnet access control updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string username: the username of the user.
 *      - string hostname: the name of the host the user came from.
 *      - string accessctrl: the access control value.
 * }
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class mnet_access_control_updated extends base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'mnet_sso_access_control';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventaccesscontrolupdated', 'mnet');
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/mnet/access_control.php');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated access control for the user with username '{$this->other['username']}' " .
            "belonging to mnet host '{$this->other['hostname']}'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'admin/mnet', 'update', 'admin/mnet/access_control.php', 'SSO ACL: ' . $this->other['accessctrl'] .
            ' user \'' . $this->other['username'] . '\' from ' . $this->other['hostname']);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['username'])) {
            throw new \coding_exception('The \'username\' value must be set in other.');
        }

        if (!isset($this->other['hostname'])) {
            throw new \coding_exception('The \'hostname\' value must be set in other.');
        }

        if (!isset($this->other['accessctrl'])) {
            throw new \coding_exception('The \'accessctrl\' value must be set in other.');
        }
    }
}
