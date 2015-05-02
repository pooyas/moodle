<?php

/**
 * Course completion critieria - student self marked
 *
 * @package core_completion
 * @category completion
 * @copyright 2009 Catalyst IT Ltd
 * @author Aaron Barnes <aaronb@catalyst.net.nz>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

/**
 * Course completion critieria - student self marked
 *
 * @package core_completion
 * @category completion
 * @copyright 2009 Catalyst IT Ltd
 * @author Aaron Barnes <aaronb@catalyst.net.nz>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class completion_criteria_self extends completion_criteria {

    /* @var int Criteria type constant [COMPLETION_CRITERIA_TYPE_SELF] */
    public $criteriatype = COMPLETION_CRITERIA_TYPE_SELF;

    /**
     * Finds and returns a data_object instance based on params.
     *
     * @param array $params associative arrays varname=>value
     * @return data_object data_object instance or false if none found.
     */
    public static function fetch($params) {
        $params['criteriatype'] = COMPLETION_CRITERIA_TYPE_SELF;
        return self::fetch_helper('course_completion_criteria', __CLASS__, $params);
    }

    /**
     * Add appropriate form elements to the critieria form
     *
     * @param lionform $mform  Lion forms object
     * @param stdClass $data Form data
     */
    public function config_form_display(&$mform, $data = null) {
        $mform->addElement('checkbox', 'criteria_self', get_string('enable'));

        if ($this->id ) {
           $mform->setDefault('criteria_self', 1);
        }
    }

    /**
     * Update the criteria information stored in the database
     *
     * @param stdClass $data Form data
     */
    public function update_config(&$data) {
        if (!empty($data->criteria_self)) {
            $this->course = $data->id;
            $this->insert();
        }
    }

    /**
     * Mark this criteria as complete
     *
     * @param completion_completion $completion The user's completion record
     */
    public function complete($completion) {
        $this->review($completion, true, true);
    }

    /**
     * Review this criteria and decide if the user has completed
     *
     * @param completion_completion $completion     The user's completion record
     * @param bool $mark Optionally set false to not save changes to database
     * @param bool $is_complete set true to mark activity complete.
     * @return bool
     */
    public function review($completion, $mark = true, $is_complete = false) {
        // If we are marking this as complete
        if ($is_complete && $mark) {
            $completion->completedself = 1;
            $completion->mark_complete();

            return true;
        }

        return $completion->is_complete();
    }

    /**
     * Return criteria title for display in reports
     *
     * @return string
     */
    public function get_title() {
        return get_string('selfcompletion', 'completion');
    }

    /**
     * Return a more detailed criteria title for display in reports
     *
     * @return string
     */
    public function get_title_detailed() {
        return $this->get_title();
    }

    /**
     * Return criteria type title for display in reports
     *
     * @return string
     */
    public function get_type_title() {
        return get_string('self', 'completion');
    }

    /**
     * Return criteria progress details for display in reports
     *
     * @param completion_completion $completion The user's completion record
     * @return array An array with the following keys:
     *     type, criteria, requirement, status
     */
    public function get_details($completion) {
        $details = array();
        $details['type'] = $this->get_title();
        $details['criteria'] = $this->get_title();
        $details['requirement'] = get_string('markingyourselfcomplete', 'completion');
        $details['status'] = '';

        return $details;
    }
}
