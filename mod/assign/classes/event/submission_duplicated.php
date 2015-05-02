<?php

/**
 * The mod_assign submission duplicated event.
 *
 * @package    mod_assign
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign submission duplicated event class.
 *
 * @package    mod_assign
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class submission_duplicated extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \assign $assign
     * @param \stdClass $submission
     * @return submission_duplicated
     */
    public static function create_from_submission(\assign $assign, \stdClass $submission) {
        $data = array(
            'objectid' => $submission->id,
            'context' => $assign->get_context(),
        );
        self::$preventcreatecall = false;
        /** @var submission_duplicated $event */
        $event = self::create($data);
        self::$preventcreatecall = true;
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
        return "The user with id '$this->userid' duplicated their submission with id '$this->objectid' for the " .
            "assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubmissionduplicated', 'mod_assign');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'assign_submission';
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $submission = $this->get_record_snapshot('assign_submission', $this->objectid);
        $this->set_legacy_logdata('submissioncopied', $this->assign->format_submission_for_log($submission));
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call submission_duplicated::create() directly, use submission_duplicated::create_from_submission() instead.');
        }

        parent::validate_data();
    }
}
