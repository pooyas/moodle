<?php



/**
 * Set tracking option for the forum.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 */

require_once("../../config.php");
require_once("lib.php");

$id         = required_param('id',PARAM_INT);                           // The forum to subscribe or unsubscribe to
$returnpage = optional_param('returnpage', 'index.php', PARAM_FILE);    // Page to return to.

require_sesskey();

if (! $forum = $DB->get_record("forum", array("id" => $id))) {
    print_error('invalidforumid', 'forum');
}

if (! $course = $DB->get_record("course", array("id" => $forum->course))) {
    print_error('invalidcoursemodule');
}

if (! $cm = get_coursemodule_from_instance("forum", $forum->id, $course->id)) {
    print_error('invalidcoursemodule');
}
require_login($course, false, $cm);

$returnto = forum_go_back_to($returnpage.'?id='.$course->id.'&f='.$forum->id);

if (!forum_tp_can_track_forums($forum)) {
    redirect($returnto);
}

$info = new stdClass();
$info->name  = fullname($USER);
$info->forum = format_string($forum->name);

$eventparams = array(
    'context' => context_module::instance($cm->id),
    'relateduserid' => $USER->id,
    'other' => array('forumid' => $forum->id),
);

if (forum_tp_is_tracked($forum) ) {
    if (forum_tp_stop_tracking($forum->id)) {
        $event = \mod_forum\event\readtracking_disabled::create($eventparams);
        $event->trigger();
        redirect($returnto, get_string("nownottracking", "forum", $info), 1);
    } else {
        print_error('cannottrack', '', $_SERVER["HTTP_REFERER"]);
    }

} else { // subscribe
    if (forum_tp_start_tracking($forum->id)) {
        $event = \mod_forum\event\readtracking_enabled::create($eventparams);
        $event->trigger();
        redirect($returnto, get_string("nowtracking", "forum", $info), 1);
    } else {
        print_error('cannottrack', '', $_SERVER["HTTP_REFERER"]);
    }
}


