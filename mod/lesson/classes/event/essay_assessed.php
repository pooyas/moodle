<?php

/**
 * The mod_lesson essay assessed event.
 *
 * @package    mod_lesson
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_lesson\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lesson essay assessed event class.
 *
 * @property-read array $other {
 *     Extra information about the event.
 *
 *     - int lessonid: The ID of the lesson.
 *     - int attemptid: The ID for the attempt.
 * }
 *
 * @package    mod_lesson
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class essay_assessed extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'lesson_grades';
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has marked the essay with id '{$this->other['attemptid']}' and " .
            "recorded a mark '$this->objectid' in the lesson with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $lesson = $this->get_record_snapshot('lesson', $this->other['lessonid']);
        return array($this->courseid, 'lesson', 'update grade', 'essay.php?id=' .
                $this->contextinstanceid, $lesson->name, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventessayassessed', 'mod_lesson');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/lesson/essay.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
        if (!isset($this->other['lessonid'])) {
            throw new \coding_exception('The \'lessonid\' value must be set in other.');
        }
        if (!isset($this->other['attemptid'])) {
            throw new \coding_exception('The \'attemptid\' value must be set in other.');
        }
    }
}
