<?php

/**
 * Grade edited event.
 *
 * @package    core
 * @copyright  2014 Petr Skoda
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Event triggered after teacher edits manual grade or
 * overrides activity/aggregated grade.
 *
 * Note: use grade_grades_history table if you need to know
 *       the history of grades.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int itemid: grade item id.
 *      - bool overridden: (optional) Is this grade override?
 *      - float finalgrade: (optional) the final grade value.
 * }
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2013 Petr Skoda
 * 
 */
class user_graded extends base {
    /** @var \grade_grade $grade */
    protected $grade;

    /**
     * Utility method to create new event.
     *
     * @param \grade_grade $grade
     * @return user_graded
     */
    public static function create_from_grade(\grade_grade $grade) {
        $event = self::create(array(
            'context'       => \context_course::instance($grade->grade_item->courseid),
            'objectid'      => $grade->id,
            'relateduserid' => $grade->userid,
            'other'         => array(
                'itemid'     => $grade->itemid,
                'overridden' => !empty($grade->overridden),
                'finalgrade' => $grade->finalgrade),
        ));
        $event->grade = $grade;
        return $event;
    }

    /**
     * Get grade object.
     *
     * @throws \coding_exception
     * @return \grade_grade
     */
    public function get_grade() {
        if ($this->is_restored()) {
            throw new \coding_exception('get_grade() is intended for event observers only');
        }
        return $this->grade;
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'grade_grades';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventusergraded', 'core_grades');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the grade with id '$this->objectid' for the user with " .
            "id '$this->relateduserid' for the grade item with id '{$this->other['itemid']}'.";
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/grade/edit/tree/grade.php', array(
            'courseid' => $this->courseid,
            'itemid'   => $this->other['itemid'],
            'userid'   => $this->relateduserid,
        ));
    }

    /**
     * Return legacy log info.
     *
     * @return null|array of parameters to be passed to legacy add_to_log() function.
     */
    public function get_legacy_logdata() {
        $user = $this->get_record_snapshot('user', $this->relateduserid);
        $fullname = fullname($user);
        $info = $this->grade->grade_item->itemname . ': ' . $fullname;
        $url = '/report/grader/index.php?id=' . $this->courseid;

        return array($this->courseid, 'grade', 'update', $url, $info);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['itemid'])) {
            throw new \coding_exception('The \'itemid\' value must be set in other.');
        }
    }
}
