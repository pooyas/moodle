<?php

/**
 * Web service function called event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Web service function called event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string function: name of the function.
 * }
 *
 */
class webservice_function_called extends base {

    /**
     * Legacy log data.
     */
    protected $legacylogdata;

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The web service function '{$this->other['function']}' has been called.";
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
        return get_string('eventwebservicefunctioncalled', 'webservice');
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
     * Return the legacy event log data.
     *
     * @param array $legacydata the legacy data to set
     */
    public function set_legacy_logdata($legacydata) {
        $this->legacylogdata = $legacydata;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['function'])) {
           throw new \coding_exception('The \'function\' value must be set in other.');
        }
    }
}
