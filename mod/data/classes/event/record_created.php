<?php

/**
 * The mod_data record created event.
 *
 * @package    mod_data
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_data\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_data record created event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int dataid: the id of the data activity.
 * }
 *
 * @package    mod_data
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class record_created extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'data_records';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventrecordcreated', 'mod_data');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' created the data record with id '$this->objectid' for the data activity " .
            "with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/data/view.php', array('d' => $this->other['dataid'], 'rid' => $this->objectid));
    }

    /**
     * Get the legacy event log data.
     *
     * @return array
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'data', 'add', 'view.php?d=' . $this->other['dataid'] . '&amp;rid=' . $this->objectid,
            $this->other['dataid'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['dataid'])) {
            throw new \coding_exception('The \'dataid\' value must be set in other.');
        }
    }
}
