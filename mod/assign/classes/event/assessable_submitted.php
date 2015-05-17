<?php


/**
 * The mod_assign assessable submitted event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign assessable submitted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - bool submission_editable: is submission editable.
 * }
 *
 */
class assessable_submitted extends base {
    /**
     * Create instance of event.
     *
     *
     * @param \assign $assign
     * @param \stdClass $submission
     * @param bool $editable
     * @return assessable_submitted
     */
    public static function create_from_submission(\assign $assign, \stdClass $submission, $editable) {
        global $USER;

        $data = array(
            'context' => $assign->get_context(),
            'objectid' => $submission->id,
            'other' => array(
                'submission_editable' => $editable,
            ),
        );
        if (!empty($submission->userid) && ($submission->userid != $USER->id)) {
            $data['relateduserid'] = $submission->userid;
        }
        /** @var assessable_submitted $event */
        $event = self::create($data);
        $event->set_assign($assign);
        $event->add_record_snapshot('assign_submission', $submission);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has submitted the submission with id '$this->objectid' " .
            "for the assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $eventdata = new \stdClass();
        $eventdata->modulename = 'assign';
        $eventdata->cmid = $this->contextinstanceid;
        $eventdata->itemid = $this->objectid;
        $eventdata->courseid = $this->courseid;
        $eventdata->userid = $this->userid;
        $eventdata->params = array('submission_editable' => $this->other['submission_editable']);
        return $eventdata;
    }

    /**
     * Return the legacy event name.
     *
     * @return string
     */
    public static function get_legacy_eventname() {
        return 'assessable_submitted';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessablesubmitted', 'mod_assign');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'assign_submission';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $submission = $this->get_record_snapshot('assign_submission', $this->objectid);
        $this->set_legacy_logdata('submit for grading', $this->assign->format_submission_for_log($submission));
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['submission_editable'])) {
            throw new \coding_exception('The \'submission_editable\' value must be set in other.');
        }
    }
}
