<?php

/**
 * Grade deleted event.
 *
 * @package    core
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Grade deleted event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int itemid: grade item id.
 *      - bool overridden: is this a grade override?
 *      - float finalgrade: (optional) the final grade value.
 * }
 *
 * @package    core
 * @since      Lion 2.8
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
class grade_deleted extends base {

    /** @var \grade_grade $grade */
    protected $grade;

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['objecttable'] = 'grade_grades';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Utility method to create new event.
     *
     * @param \grade_grade $grade
     * @return user_graded
     */
    public static function create_from_grade(\grade_grade $grade) {
        $event = self::create(array(
            'objectid'      => $grade->id,
            'context'       => \context_course::instance($grade->grade_item->courseid),
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
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgradedeleted', 'core_grades');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the grade with id '$this->objectid' for the user with " .
            "id '$this->relateduserid' for the grade item with id '{$this->other['itemid']}'.";
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

        if (!isset($this->other['overridden'])) {
            throw new \coding_exception('The \'overridden\' value must be set in other.');
        }
    }
}
