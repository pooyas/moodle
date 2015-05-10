<?php

/**
 * The mod_workshop assessment_reevaluated event.
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_workshop\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_workshop assessment_reevaluated event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - float currentgrade: (may be null) current saved grade.
 *      - float finalgrade: (may be null) final grade.
 * }
 *
 */
class assessment_reevaluated extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'workshop_aggregations';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has had their assessment attempt reevaluated for the workshop with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'workshop', 'update aggregate grade', 'view.php?id=' . $this->contextinstanceid,
                $this->objectid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessmentreevaluated', 'mod_workshop');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/workshop/view.php', array('id' => $this->contextinstanceid));
    }
}
