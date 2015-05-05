<?php

/**
 * Event observer.
 *
 * @package    block
 * @subpackage recent_activity
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Event observer.
 * Stores all actions about modules create/update/delete in plugin own's table.
 * This allows the block to avoid expensive queries to the log table.
 *
 */
class block_recent_activity_observer {

    /** @var int indicates that course module was created */
    const CM_CREATED = 0;
    /** @var int indicates that course module was udpated */
    const CM_UPDATED = 1;
    /** @var int indicates that course module was deleted */
    const CM_DELETED = 2;

    /**
     * Store all actions about modules create/update/delete in own table.
     *
     * @param \core\event\base $event
     */
    public static function store(\core\event\base $event) {
        global $DB;
        $eventdata = new \stdClass();
        switch ($event->eventname) {
            case '\core\event\course_module_created':
                $eventdata->action = self::CM_CREATED;
                break;
            case '\core\event\course_module_updated':
                $eventdata->action = self::CM_UPDATED;
                break;
            case '\core\event\course_module_deleted':
                $eventdata->action = self::CM_DELETED;
                $eventdata->modname = $event->other['modulename'];
                break;
            default:
                return;
        }
        $eventdata->timecreated = $event->timecreated;
        $eventdata->courseid = $event->courseid;
        $eventdata->cmid = $event->objectid;
        $eventdata->userid = $event->userid;
        $DB->insert_record('block_recent_activity', $eventdata);
    }
}
