<?php


/**
 * The mod_assign submission graded event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign submission graded event class.
 *
 */
class submission_graded extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     *
     * @param \assign $assign
     * @param \stdClass $grade
     * @return submission_graded
     */
    public static function create_from_grade(\assign $assign, \stdClass $grade) {
        $data = array(
            'context' => $assign->get_context(),
            'objectid' => $grade->id,
            'relateduserid' => $grade->userid
        );
        self::$preventcreatecall = false;
        /** @var submission_graded $event */
        $event = self::create($data);
        self::$preventcreatecall = true;
        $event->set_assign($assign);
        $event->add_record_snapshot('assign_grades', $grade);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has graded the submission '$this->objectid' for the user with " .
            "id '$this->relateduserid' for the assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubmissiongraded', 'mod_assign');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'assign_grades';
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $grade = $this->get_record_snapshot('assign_grades', $this->objectid);
        $this->set_legacy_logdata('grade submission', $this->assign->format_grade_for_log($grade));
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call submission_graded::create() directly, use submission_graded::create_from_grade() instead.');
        }

        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}
