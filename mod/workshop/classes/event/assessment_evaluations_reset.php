<?php

/**
 * The mod_workshop assessment_evaluations reset event.
 *
 * @package    mod
 * @subpackage workshop
 * @category   event
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_workshop\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_workshop assessment_evaluations reset event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int workshopid: the ID of the workshop.
 * }
 *
 */
class assessment_evaluations_reset extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has reset the assessment evaluations for the workshop with course module id " .
            "'$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'workshop', 'update clear aggregated grade', 'view.php?id=' . $this->contextinstanceid,
                $this->other['workshopid'], $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessmentevaluationsreset', 'mod_workshop');
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

        if (!isset($this->other['workshopid'])) {
            throw new \coding_exception('The \'workshopid\' value must be set in other.');
        }
    }
}
