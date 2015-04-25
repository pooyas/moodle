<?php

/**
 * Course completion status for a particular user/course
 *
 * @package core
 * @subpackage completion
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/completion/data_object.php');

/**
 * Course completion status for a particular user/course
 *
 */
class completion_completion extends data_object {

    /* @var string $table Database table name that stores completion information */
    public $table = 'course_completions';

    /* @var array $required_fields Array of required table fields, must start with 'id'. */
    public $required_fields = array('id', 'userid', 'course',
        'timeenrolled', 'timestarted', 'timecompleted', 'reaggregate');

    /* @var int $userid User ID */
    public $userid;

    /* @var int $course Course ID */
    public $course;

    /* @var int Time of course enrolment {@link completion_completion::mark_enrolled()} */
    public $timeenrolled;

    /**
     * Time the user started their course completion {@link completion_completion::mark_inprogress()}
     * @var int
     */
    public $timestarted;

    /* @var int Timestamp of course completion {@link completion_completion::mark_complete()} */
    public $timecompleted;

    /* @var int Flag to trigger cron aggregation (timestamp) */
    public $reaggregate;


    /**
     * Finds and returns a data_object instance based on params.
     *
     * @param array $params associative arrays varname = >value
     * @return data_object instance of data_object or false if none found.
     */
    public static function fetch($params) {
        return self::fetch_helper('course_completions', __CLASS__, $params);
    }

    /**
     * Return status of this completion
     *
     * @return bool
     */
    public function is_complete() {
        return (bool) $this->timecompleted;
    }

    /**
     * Mark this user as started (or enrolled) in this course
     *
     * If the user is already marked as started, no change will occur
     *
     * @param integer $timeenrolled Time enrolled (optional)
     */
    public function mark_enrolled($timeenrolled = null) {

        if ($this->timeenrolled === null) {

            if ($timeenrolled === null) {
                $timeenrolled = time();
            }

            $this->timeenrolled = $timeenrolled;
        }

        return $this->_save();
    }

    /**
     * Mark this user as inprogress in this course
     *
     * If the user is already marked as inprogress, the time will not be changed
     *
     * @param integer $timestarted Time started (optional)
     */
    public function mark_inprogress($timestarted = null) {

        $timenow = time();

        // Set reaggregate flag
        $this->reaggregate = $timenow;

        if (!$this->timestarted) {

            if (!$timestarted) {
                $timestarted = $timenow;
            }

            $this->timestarted = $timestarted;
        }

        return $this->_save();
    }

    /**
     * Mark this user complete in this course
     *
     * This generally happens when the required completion criteria
     * in the course are complete.
     *
     * @param integer $timecomplete Time completed (optional)
     * @return void
     */
    public function mark_complete($timecomplete = null) {
        global $USER;

        // Never change a completion time.
        if ($this->timecompleted) {
            return;
        }

        // Use current time if nothing supplied.
        if (!$timecomplete) {
            $timecomplete = time();
        }

        // Set time complete.
        $this->timecompleted = $timecomplete;

        // Save record.
        if ($result = $this->_save()) {
            $data = $this->get_record_data();
            \core\event\course_completed::create_from_completion($data)->trigger();
        }

        return $result;
    }

    /**
     * Save course completion status
     *
     * This method creates a course_completions record if none exists
     * @access  private
     * @return  bool
     */
    private function _save() {
        if ($this->timeenrolled === null) {
            $this->timeenrolled = 0;
        }

        // Save record
        if ($this->id) {
            return $this->update();
        } else {
            // Make sure reaggregate field is not null
            if (!$this->reaggregate) {
                $this->reaggregate = 0;
            }

            // Make sure timestarted is not null
            if (!$this->timestarted) {
                $this->timestarted = 0;
            }

            return $this->insert();
        }
    }
}
