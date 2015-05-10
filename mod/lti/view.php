<?php

/**
 * This file contains all necessary code to view a lti activity instance
 *
 * @package mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once('../../config.php');
require_once($CFG->libdir.'/completionlib.php');
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
$l  = optional_param('l', 0, PARAM_INT);  // lti ID.

if ($l) {  // Two ways to specify the module.
    $lti = $DB->get_record('lti', array('id' => $l), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('lti', $lti->id, $lti->course, false, MUST_EXIST);

} else {
    $cm = get_coursemodule_from_id('lti', $id, 0, false, MUST_EXIST);
    $lti = $DB->get_record('lti', array('id' => $cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

if (!empty($lti->typeid)) {
    $toolconfig = lti_get_type_config($lti->typeid);
} else if ($tool = lti_get_tool_by_url_match($lti->toolurl)) {
    $toolconfig = lti_get_type_config($tool->id);
} else {
    $toolconfig = array();
}

$PAGE->set_cm($cm, $course); // Set's up global $COURSE.
$context = context_module::instance($cm->id);
$PAGE->set_context($context);

require_login($course, true, $cm);
require_capability('mod/lti:view', $context);

$url = new lion_url('/mod/lti/view.php', array('id' => $cm->id));
$PAGE->set_url($url);

$launchcontainer = lti_get_launch_container($lti, $toolconfig);

if ($launchcontainer == LTI_LAUNCH_CONTAINER_EMBED_NO_BLOCKS) {
    $PAGE->set_pagelayout('frametop'); // Most frametops don't include footer, and pre-post blocks.
    $PAGE->blocks->show_only_fake_blocks(); // Disable blocks for layouts which do include pre-post blocks.
} else if ($launchcontainer == LTI_LAUNCH_CONTAINER_REPLACE_LION_WINDOW) {
    redirect('launch.php?id=' . $cm->id);
} else {
    $PAGE->set_pagelayout('incourse');
}

// Mark viewed by user (if required).
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

$params = array(
    'context' => $context,
    'objectid' => $lti->id
);
$event = \mod_lti\event\course_module_viewed::create($params);
$event->add_record_snapshot('course_modules', $cm);
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('lti', $lti);
$event->trigger();

$pagetitle = strip_tags($course->shortname.': '.format_string($lti->name));
$PAGE->set_title($pagetitle);
$PAGE->set_heading($course->fullname);

// Print the page header.
echo $OUTPUT->header();

if ($lti->showtitlelaunch) {
    // Print the main part of the page.
    echo $OUTPUT->heading(format_string($lti->name, true, array('context' => $context)));
}

if ($lti->showdescriptionlaunch && $lti->intro) {
    echo $OUTPUT->box(format_module_intro('lti', $lti, $cm->id), 'generalbox description', 'intro');
}

if ( $launchcontainer == LTI_LAUNCH_CONTAINER_WINDOW ) {
    echo "<script language=\"javascript\">//<![CDATA[\n";
    echo "window.open('launch.php?id=".$cm->id."','lti');";
    echo "//]]\n";
    echo "</script>\n";
    echo "<p>".get_string("basiclti_in_new_window", "lti")."</p>\n";
} else {
    // Request the launch content with an iframe tag.
    echo '<iframe id="contentframe" height="600px" width="100%" src="launch.php?id='.$cm->id.'"></iframe>';

    // Output script to make the iframe tag be as large as possible.
    $resize = '
        <script type="text/javascript">
        //<![CDATA[
            YUI().use("node", "event", function(Y) {
                //Take scrollbars off the outer document to prevent double scroll bar effect
                var doc = Y.one("body");
                doc.setStyle("overflow", "hidden");

                var frame = Y.one("#contentframe");
                var padding = 15; //The bottom of the iframe wasn\'t visible on some themes. Probably because of border widths, etc.
                var lastHeight;
                var resize = function(e) {
                    var viewportHeight = doc.get("winHeight");
                    if(lastHeight !== Math.min(doc.get("docHeight"), viewportHeight)){
                        frame.setStyle("height", viewportHeight - frame.getY() - padding + "px");
                        lastHeight = Math.min(doc.get("docHeight"), doc.get("winHeight"));
                    }
                };

                resize();

                Y.on("windowresize", resize);
            });
        //]]
        </script>
';

    echo $resize;
}

// Finish the page.
echo $OUTPUT->footer();
