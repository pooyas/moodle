<?php

require_once('../../../config.php');
require_once('../lib.php');

$id      = required_param('id', PARAM_INT);
$groupid = optional_param('groupid', 0, PARAM_INT); // Only for teachers.

$url = new lion_url('/mod/chat/gui_sockets/index.php', array('id' => $id));
if ($groupid !== 0) {
    $url->param('groupid', $groupid);
}
$PAGE->set_url($url);

if (!$chat = $DB->get_record('chat', array('id' => $id))) {
    print_error('invalidid', 'chat');
}

if (!$course = $DB->get_record('course', array('id' => $chat->course))) {
    print_error('invalidcourseid');
}

if (!$cm = get_coursemodule_from_instance('chat', $chat->id, $course->id)) {
    print_error('invalidcoursemodule');
}

require_login($course, false, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/chat:chat', $context);

// Check to see if groups are being used here
if ($groupmode = groups_get_activity_groupmode($cm)) {   // Groups are being used.
    if ($groupid = groups_get_activity_group($cm)) {
        if (!$group = groups_get_group($groupid)) {
            print_error('invalidgroupid');
        }
        $groupname = ': '.$group->name;
    } else {
        $groupname = ': '.get_string('allparticipants');
    }
} else {
    $groupid = 0;
    $groupname = '';
}

$strchat = get_string('modulename', 'chat'); // Must be before current_language() in chat_login_user() to force course language!

if (!$chatsid = chat_login_user($chat->id, 'sockets', $groupid, $course)) {
    print_error('cantlogin');
}

$params = "chat_sid=$chatsid";
$courseshortname = format_string($course->shortname, true, array('context' => context_course::instance($course->id)));

$chatname = format_string($chat->name, true, array('context' => $context));
$winchaturl = "http://$CFG->chat_serverhost:$CFG->chat_serverport?win=chat&amp;$params";
$winusersurl = "http://$CFG->chat_serverhost:$CFG->chat_serverport?win=users&amp;$params"

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>
   <?php echo "$strchat: " . $courseshortname . ": " . $chatname . "$groupname" ?>
  </title>
 </head>
 <frameset cols="*,200" border="5" framespacing="no" frameborder="yes" marginwidth="2" marginheight="1">
  <frameset rows="0,*,70" border="0" framespacing="no" frameborder="no" marginwidth="2" marginheight="1">
   <frame src="../empty.php" name="empty" scrolling="auto" noresize marginwidth="2" marginheight="0">
   <frame src="<?php echo $winchaturl; ?>" scrolling="auto" name="msg" noresize marginwidth="2" marginheight="0">
   <frame src="chatinput.php?<?php echo $params ?>" name="input" scrolling="no" marginwidth="2" marginheight="1">
  </frameset>
  <frame src="<?php echo $winusersurl; ?>" name="users" scrolling="auto" marginwidth="5" marginheight="5">
 </frameset>
 <noframes>
  Sorry, this version of Lion Chat needs a browser that handles frames.
 </noframes>
</html>
