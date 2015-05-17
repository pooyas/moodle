<?php


/**
 * User login failed event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * User login failed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string username: name of user.
 *      - int reason: failure reason.
 * }
 *
 */
class user_login_failed extends base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserloginfailed', 'auth');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        // Note that username could be any random user input.
        $username = s($this->other['username']);
        return "Login failed for the username '{$username}' for the reason with id '{$this->other['reason']}'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        if (isset($this->data['userid'])) {
            return new \lion_url('/user/profile.php', array('id' => $this->data['userid']));
        } else {
            return null;
        }
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'login', 'error', 'index.php', $this->other['username']);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['reason'])) {
            throw new \coding_exception('The \'reason\' value must be set in other.');
        }

        if (!isset($this->other['username'])) {
            throw new \coding_exception('The \'username\' value must be set in other.');
        }
    }

}
