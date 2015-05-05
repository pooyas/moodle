<?php

/**
 * Category enrolment plugin.
 *
 * @package    enrol
 * @subpackage category
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * category enrolment plugin implementation.
 */
class enrol_category_plugin extends enrol_plugin {

   /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
        global $DB;

        $context = context_course::instance($instance->courseid);
        if (!has_capability('enrol/category:config', $context)) {
            return false;
        }

        if (!enrol_is_enabled('category')) {
            return true;
        }
        // Allow delete only when no synced users here.
        return !$DB->record_exists('user_enrolments', array('enrolid'=>$instance->id));
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/category:config', $context);
    }

    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return lion_url page url
     */
    public function get_newinstance_link($courseid) {
        // Instances are added automatically as necessary.
        return null;
    }

    /**
     * Called for all enabled enrol plugins that returned true from is_cron_required().
     * @return void
     */
    public function cron() {
        global $CFG;

        if (!enrol_is_enabled('category')) {
            return;
        }

        require_once("$CFG->dirroot/enrol/category/locallib.php");
        $trace = new null_progress_trace();
        enrol_category_sync_full($trace);
    }

    /**
     * Called after updating/inserting course.
     *
     * @param bool $inserted true if course just inserted
     * @param stdClass $course
     * @param stdClass $data form data
     * @return void
     */
    public function course_updated($inserted, $course, $data) {
        global $CFG;

        if (!enrol_is_enabled('category')) {
            return;
        }

        // Sync category enrols.
        require_once("$CFG->dirroot/enrol/category/locallib.php");
        enrol_category_sync_course($course);
    }

    /**
     * Automatic enrol sync executed during restore.
     * Useful for automatic sync by course->idnumber or course category.
     * @param stdClass $course course record
     */
    public function restore_sync_course($course) {
        global $CFG;
        require_once("$CFG->dirroot/enrol/category/locallib.php");
        enrol_category_sync_course($course);
    }
}
