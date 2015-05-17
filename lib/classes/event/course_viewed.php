<?php


/**
 * Course viewed event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Course viewed event class.
 *
 * Class for event to be triggered when a course is viewed.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int coursesectionnumber: (optional) The course section number.
 * }
 *
 */
class course_viewed extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {

        // We keep compatibility with 2.7 and 2.8 other['coursesectionid'].
        $sectionstr = '';
        if (!empty($this->other['coursesectionnumber'])) {
            $sectionstr = "section number '{$this->other['coursesectionnumber']}' of the ";
        } else if (!empty($this->other['coursesectionid'])) {
            $sectionstr = "section number '{$this->other['coursesectionid']}' of the ";
        }
        $description = "The user with id '$this->userid' viewed the " . $sectionstr . "course with id '$this->courseid'.";

        return $description;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcourseviewed', 'core');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url|null
     */
    public function get_url() {
        global $CFG;

        // We keep compatibility with 2.7 and 2.8 other['coursesectionid'].
        $sectionnumber = null;
        if (isset($this->other['coursesectionnumber'])) {
            $sectionnumber = $this->other['coursesectionnumber'];
        } else if (isset($this->other['coursesectionid'])) {
            $sectionnumber = $this->other['coursesectionid'];
        }
        require_once($CFG->dirroot . '/course/lib.php');
        try {
            return course_get_url($this->courseid, $sectionnumber);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        if ($this->courseid == SITEID and !isloggedin()) {
            // We did not log frontpage access in older Lion versions.
            return null;
        }

        // We keep compatibility with 2.7 and 2.8 other['coursesectionid'].
        if (isset($this->other['coursesectionnumber']) || isset($this->other['coursesectionid'])) {
            if (isset($this->other['coursesectionnumber'])) {
                $sectionnumber = $this->other['coursesectionnumber'];
            } else {
                $sectionnumber = $this->other['coursesectionid'];
            }
            return array($this->courseid, 'course', 'view section', 'view.php?id=' . $this->courseid . '&amp;section='
                    . $sectionnumber, $sectionnumber);
        }
        return array($this->courseid, 'course', 'view', 'view.php?id=' . $this->courseid, $this->courseid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context level must be CONTEXT_COURSE.');
        }
    }
}
