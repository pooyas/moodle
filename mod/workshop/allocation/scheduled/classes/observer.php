<?php

/**
 * Event observers for workshopallocation_scheduled.
 *
 * @package workshopallocation
 * @subpackage scheduled
 * @copyright 2015 Pooya Saeedi
 * 
 */

namespace workshopallocation_scheduled;
defined('LION_INTERNAL') || die();

/**
 * Class for workshopallocation_scheduled observers.
 *
 */
class observer {

    /**
     * Triggered when the '\mod_workshop\event\course_module_viewed' event is triggered.
     *
     * This does the same job as {@link workshopallocation_scheduled_cron()} but for the
     * single workshop. The idea is that we do not need to wait for cron to execute.
     * Displaying the workshop main view.php can trigger the scheduled allocation, too.
     *
     * @param \mod_workshop\event\course_module_viewed $event
     * @return bool
     */
    public static function workshop_viewed($event) {
        global $DB, $CFG;

        require_once($CFG->dirroot . '/mod/workshop/locallib.php');

        $workshop = $event->get_record_snapshot('workshop', $event->objectid);
        $course   = $event->get_record_snapshot('course', $event->courseid);
        $cm       = $event->get_record_snapshot('course_modules', $event->contextinstanceid);

        $workshop = new \workshop($workshop, $cm, $course);
        $now = time();

        // Non-expensive check to see if the scheduled allocation can even happen.
        if ($workshop->phase == \workshop::PHASE_SUBMISSION and $workshop->submissionend > 0 and $workshop->submissionend < $now) {

            // Make sure the scheduled allocation has been configured for this workshop, that it has not
            // been executed yet and that the passed workshop record is still valid.
            $sql = "SELECT a.id
                      FROM {workshopallocation_scheduled} a
                      JOIN {workshop} w ON a.workshopid = w.id
                     WHERE w.id = :workshopid
                           AND a.enabled = 1
                           AND w.phase = :phase
                           AND w.submissionend > 0
                           AND w.submissionend < :now
                           AND (a.timeallocated IS NULL OR a.timeallocated < w.submissionend)";
            $params = array('workshopid' => $workshop->id, 'phase' => \workshop::PHASE_SUBMISSION, 'now' => $now);

            if ($DB->record_exists_sql($sql, $params)) {
                // Allocate submissions for assessments.
                $allocator = $workshop->allocator_instance('scheduled');
                $result = $allocator->execute();
                // Todo inform the teachers about the results.
            }
        }
        return true;
    }
}
