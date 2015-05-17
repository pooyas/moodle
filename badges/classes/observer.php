<?php


/**
 * Local stuff for category enrolment plugin.
 *
 * @package    badges
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Event observer for badges.
 */
class core_badges_observer {
    /**
     * Triggered when 'course_module_completion_updated' event is triggered.
     *
     * @param \core\event\course_module_completion_updated $event
     */
    public static function course_module_criteria_review(\core\event\course_module_completion_updated $event) {
        global $DB, $CFG;

        if (!empty($CFG->enablebadges)) {
            require_once($CFG->dirroot.'/lib/badgeslib.php');

            $eventdata = $event->get_record_snapshot('course_modules_completion', $event->objectid);
            $userid = $event->relateduserid;
            $mod = $event->contextinstanceid;

            if ($eventdata->completionstate == COMPLETION_COMPLETE
                || $eventdata->completionstate == COMPLETION_COMPLETE_PASS
                || $eventdata->completionstate == COMPLETION_COMPLETE_FAIL) {
                // Need to take into account that there can be more than one badge with the same activity in its criteria.
                if ($rs = $DB->get_records('badge_criteria_param', array('name' => 'module_' . $mod, 'value' => $mod))) {
                    foreach ($rs as $r) {
                        $bid = $DB->get_field('badge_criteria', 'badgeid', array('id' => $r->critid), MUST_EXIST);
                        $badge = new badge($bid);
                        if (!$badge->is_active() || $badge->is_issued($userid)) {
                            continue;
                        }

                        if ($badge->criteria[BADGE_CRITERIA_TYPE_ACTIVITY]->review($userid)) {
                            $badge->criteria[BADGE_CRITERIA_TYPE_ACTIVITY]->mark_complete($userid);

                            if ($badge->criteria[BADGE_CRITERIA_TYPE_OVERALL]->review($userid)) {
                                $badge->criteria[BADGE_CRITERIA_TYPE_OVERALL]->mark_complete($userid);
                                $badge->issue($userid);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Triggered when 'course_completed' event is triggered.
     *
     * @param \core\event\course_completed $event
     */
    public static function course_criteria_review(\core\event\course_completed $event) {
        global $DB, $CFG;

        if (!empty($CFG->enablebadges)) {
            require_once($CFG->dirroot.'/lib/badgeslib.php');

            $eventdata = $event->get_record_snapshot('course_completions', $event->objectid);
            $userid = $event->relateduserid;
            $courseid = $event->courseid;

            // Need to take into account that course can be a part of course_completion and courseset_completion criteria.
            if ($rs = $DB->get_records('badge_criteria_param', array('name' => 'course_' . $courseid, 'value' => $courseid))) {
                foreach ($rs as $r) {
                    $crit = $DB->get_record('badge_criteria', array('id' => $r->critid), 'badgeid, criteriatype', MUST_EXIST);
                    $badge = new badge($crit->badgeid);
                    if (!$badge->is_active() || $badge->is_issued($userid)) {
                        continue;
                    }

                    if ($badge->criteria[$crit->criteriatype]->review($userid)) {
                        $badge->criteria[$crit->criteriatype]->mark_complete($userid);

                        if ($badge->criteria[BADGE_CRITERIA_TYPE_OVERALL]->review($userid)) {
                            $badge->criteria[BADGE_CRITERIA_TYPE_OVERALL]->mark_complete($userid);
                            $badge->issue($userid);
                        }
                    }
                }
            }
        }
    }

    /**
     * Triggered when 'user_updated' event happens.
     *
     * @param \core\event\user_updated $event event generated when user profile is updated.
     */
    public static function profile_criteria_review(\core\event\user_updated $event) {
        global $DB, $CFG;

        if (!empty($CFG->enablebadges)) {
            require_once($CFG->dirroot.'/lib/badgeslib.php');
            $userid = $event->objectid;

            if ($rs = $DB->get_records('badge_criteria', array('criteriatype' => BADGE_CRITERIA_TYPE_PROFILE))) {
                foreach ($rs as $r) {
                    $badge = new badge($r->badgeid);
                    if (!$badge->is_active() || $badge->is_issued($userid)) {
                        continue;
                    }

                    if ($badge->criteria[BADGE_CRITERIA_TYPE_PROFILE]->review($userid)) {
                        $badge->criteria[BADGE_CRITERIA_TYPE_PROFILE]->mark_complete($userid);

                        if ($badge->criteria[BADGE_CRITERIA_TYPE_OVERALL]->review($userid)) {
                            $badge->criteria[BADGE_CRITERIA_TYPE_OVERALL]->mark_complete($userid);
                            $badge->issue($userid);
                        }
                    }
                }
            }
        }
    }
}
