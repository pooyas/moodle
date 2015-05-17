<?php


/**
 * Web service login failed event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Web service login failed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string method: authentication method.
 *      - string reason: failure reason.
 *      - string tokenid: id of token.
 * }
 *
 */
class webservice_login_failed extends base {

    /**
     * Legacy log data.
     *
     * @var null|array
     */
    protected $legacylogdata;

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "Web service authentication failed with code: \"{$this->other['reason']}\".";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return $this->legacylogdata;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventwebserviceloginfailed', 'webservice');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->context = \context_system::instance();
    }

    /**
     * Set the legacy event log data.
     *
     * @param array $logdata The log data.
     * @return void
     */
    public function set_legacy_logdata($logdata) {
        $this->legacylogdata = $logdata;
    }

    /**
     * Custom validation.
     *
     * It is recommended to set the properties:
     * - $other['tokenid']
     * - $other['username']
     *
     * However they are not mandatory as they are not always known.
     *
     * Please note that the token CANNOT be specified, it is considered
     * as a password and should never be displayed.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['reason'])) {
           throw new \coding_exception('The \'reason\' value must be set in other.');
        } else if (!isset($this->other['method'])) {
           throw new \coding_exception('The \'method\' value must be set in other.');
        } else if (isset($this->other['token'])) {
           throw new \coding_exception('The \'token\' value must not be set in other.');
        }
    }
}
