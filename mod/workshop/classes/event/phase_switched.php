<?php


/**
 * The mod_workshop phase switched event.
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_workshop\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_workshop phase switched event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int workshopphase: Workshop phase.
 * }
 *
 */
class phase_switched extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'workshop';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has switched the phase of the workshop with course module id " .
            "'$this->contextinstanceid' to '{$this->other['workshopphase']}'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'workshop', 'update switch phase', 'view.php?id=' . $this->contextinstanceid,
                $this->other['workshopphase'], $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventphaseswitched', 'mod_workshop');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/workshop/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['workshopphase'])) {
            throw new \coding_exception('The \'workshopphase\' value must be set in other.');
        }
    }
}
