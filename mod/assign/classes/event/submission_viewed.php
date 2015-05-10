<?php

/**
 * The mod_assign submission viewed event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign submission viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int assignid: the id of the assignment.
 * }
 *
 */
class submission_viewed extends base {
    /**
     * Create instance of event.
     *
     * @param \assign $assign
     * @param \stdClass $submission
     * @return submission_viewed
     */
    public static function create_from_submission(\assign $assign, \stdClass $submission) {
        $data = array(
            'objectid' => $submission->id,
            'relateduserid' => $submission->userid,
            'context' => $assign->get_context(),
            'other' => array(
                'assignid' => $assign->get_instance()->id,
            ),
        );
        /** @var submission_viewed $event */
        $event = self::create($data);
        $event->set_assign($assign);
        $event->add_record_snapshot('assign_submission', $submission);
        return $event;
    }

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'assign_submission';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubmissionviewed', 'mod_assign');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the submission for the user with id '$this->relateduserid' for the " .
            "assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $logmessage = get_string('viewsubmissionforuser', 'assign', $this->relateduserid);
        $this->set_legacy_logdata('view submission', $logmessage);
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['assignid'])) {
            throw new \coding_exception('The \'assignid\' value must be set in other.');
        }
    }
}
