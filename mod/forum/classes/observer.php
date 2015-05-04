<?php

/**
 * Event observers used in forum.
 *
 * @package    mod_forum
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Event observer for mod_forum.
 */
class mod_forum_observer {

    /**
     * Triggered via user_enrolment_deleted event.
     *
     * @param \core\event\user_enrolment_deleted $event
     */
    public static function user_enrolment_deleted(\core\event\user_enrolment_deleted $event) {
        global $DB;

        // NOTE: this has to be as fast as possible.
        // Get user enrolment info from event.
        $cp = (object)$event->other['userenrolment'];
        if ($cp->lastenrol) {
            $params = array('userid' => $cp->userid, 'courseid' => $cp->courseid);
            $forumselect = "IN (SELECT f.id FROM {forum} f WHERE f.course = :courseid)";

            $DB->delete_records_select('forum_digests', 'userid = :userid AND forum '.$forumselect, $params);
            $DB->delete_records_select('forum_subscriptions', 'userid = :userid AND forum '.$forumselect, $params);
            $DB->delete_records_select('forum_track_prefs', 'userid = :userid AND forumid '.$forumselect, $params);
            $DB->delete_records_select('forum_read', 'userid = :userid AND forumid '.$forumselect, $params);
        }
    }

    /**
     * Observer for role_assigned event.
     *
     * @param \core\event\role_assigned $event
     * @return void
     */
    public static function role_assigned(\core\event\role_assigned $event) {
        global $CFG, $DB;

        $context = context::instance_by_id($event->contextid, MUST_EXIST);

        // If contextlevel is course then only subscribe user. Role assignment
        // at course level means user is enroled in course and can subscribe to forum.
        if ($context->contextlevel != CONTEXT_COURSE) {
            return;
        }

        // Forum lib required for the constant used below.
        require_once($CFG->dirroot . '/mod/forum/lib.php');

        $userid = $event->relateduserid;
        $sql = "SELECT f.id, f.course as course, cm.id AS cmid, f.forcesubscribe
                  FROM {forum} f
                  JOIN {course_modules} cm ON (cm.instance = f.id)
                  JOIN {modules} m ON (m.id = cm.module)
             LEFT JOIN {forum_subscriptions} fs ON (fs.forum = f.id AND fs.userid = :userid)
                 WHERE f.course = :courseid
                   AND f.forcesubscribe = :initial
                   AND m.name = 'forum'
                   AND fs.id IS NULL";
        $params = array('courseid' => $context->instanceid, 'userid' => $userid, 'initial' => FORUM_INITIALSUBSCRIBE);

        $forums = $DB->get_records_sql($sql, $params);
        foreach ($forums as $forum) {
            // If user doesn't have allowforcesubscribe capability then don't subscribe.
            $modcontext = context_module::instance($forum->cmid);
            if (has_capability('mod/forum:allowforcesubscribe', $modcontext, $userid)) {
                \mod_forum\subscriptions::subscribe_user($userid, $forum, $modcontext);
            }
        }
    }

    /**
     * Observer for \core\event\course_module_created event.
     *
     * @param \core\event\course_module_created $event
     * @return void
     */
    public static function course_module_created(\core\event\course_module_created $event) {
        global $CFG;

        if ($event->other['modulename'] === 'forum') {
            // Include the forum library to make use of the forum_instance_created function.
            require_once($CFG->dirroot . '/mod/forum/lib.php');

            $forum = $event->get_record_snapshot('forum', $event->other['instanceid']);
            forum_instance_created($event->get_context(), $forum);
        }
    }
}
