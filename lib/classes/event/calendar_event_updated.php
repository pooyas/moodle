<?php


/**
 * Calendar event updated event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Calendar event updated event.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int repeatid: id of the parent event if present, else 0.
 *      - int timestart: timestamp for event time start.
 *      - string name: name of the event.
 * }
 *
 */
class calendar_event_updated extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'event';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcalendareventupdated', 'core_calendar');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $eventname = s($this->other['name']);
        return "The user with id '$this->userid' updated the event '$eventname' with id '$this->objectid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/calendar/event.php', array('action' => 'edit', 'id' => $this->objectid));
    }

    /**
     * Replace legacy add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'calendar', 'edit', 'event.php?action=edit&amp;id=' . $this->objectid, $this->other['name']);
    }

    /**
     * Custom validation.
     *
     * Throw \coding_exception notice in case of any problems.
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['repeatid'])) {
            throw new \coding_exception('The \'repeatid\' value must be set in other.');
        }
        if (empty($this->other['name'])) {
            throw new \coding_exception('The \'name\' value must be set in other.');
        }
        if (!isset($this->other['timestart'])) {
            throw new \coding_exception('The \'timestart\' value must be set in other.');
        }
    }
}
