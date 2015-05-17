<?php


/**
 * User loggedinas event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * User loggedinas event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string originalusername: original username.
 *      - string loggedinasusername: username of logged in as user.
 * }
 *
 */
class user_loggedinas extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'user';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventuserloggedinas', 'auth');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has logged in as the user with id '$this->relateduserid'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'course', 'loginas', '../user/view.php?id=' . $this->courseid . '&amp;user=' . $this->userid,
            $this->other['originalusername'] . ' -> ' . $this->other['loggedinasusername']);
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/user/view.php', array('id' => $this->objectid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['originalusername'])) {
            throw new \coding_exception('The \'originalusername\' value must be set in other.');
        }

        if (!isset($this->other['loggedinasusername'])) {
            throw new \coding_exception('The \'loggedinasusername\' value must be set in other.');
        }
    }
}
