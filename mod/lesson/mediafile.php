<?php


/**
 * This file plays the mediafile set in lesson settings.
 *
 *  If there is a way to use the resource class instead of this code, please change to do so
 *
 *
 * @package mod_lesson
 * @copyright  2015 Pooya Saeedi
 * 
 **/

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/lesson/locallib.php');

$id = required_param('id', PARAM_INT);    // Course Module ID
$printclose = optional_param('printclose', 0, PARAM_INT);

$cm = get_coursemodule_from_id('lesson', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$lesson = new lesson($DB->get_record('lesson', array('id' => $cm->instance), '*', MUST_EXIST));

require_login($course, false, $cm);

$context = context_module::instance($cm->id);
$canmanage = has_capability('mod/lesson:manage', $context);

$url = new lion_url('/mod/lesson/mediafile.php', array('id'=>$id));
if ($printclose !== '') {
    $url->param('printclose', $printclose);
}
$PAGE->set_url($url);
$PAGE->set_pagelayout('popup');
$PAGE->set_title($course->shortname);

$lessonoutput = $PAGE->get_renderer('mod_lesson');

// Get the mimetype
$mimetype = mimeinfo("type", $lesson->mediafile);

if ($printclose) {  // this is for framesets
    if ($lesson->mediaclose) {
        echo $lessonoutput->header($lesson, $cm);
        echo $OUTPUT->box('<form><div><input type="button" onclick="top.close();" value="'.get_string("closewindow").'" /></div></form>', 'lessonmediafilecontrol');
        echo $lessonoutput->footer();
    }
    exit();
}

echo $lessonoutput->header($lesson, $cm);

//TODO: this is copied from view.php - the access should be the same!
/// Check these for students only TODO: Find a better method for doing this!
///     Check lesson availability
///     Check for password
///     Check dependencies
///     Check for high scores
if (!$canmanage) {
    if (!$lesson->is_accessible()) {  // Deadline restrictions
        echo $lessonoutput->header($lesson, $cm);
        if ($lesson->deadline != 0 && time() > $lesson->deadline) {
            echo $lessonoutput->lesson_inaccessible(get_string('lessonclosed', 'lesson', userdate($lesson->deadline)));
        } else {
            echo $lessonoutput->lesson_inaccessible(get_string('lessonopen', 'lesson', userdate($lesson->available)));
        }
        echo $lessonoutput->footer();
        exit();
    } else if ($lesson->usepassword && empty($USER->lessonloggedin[$lesson->id])) { // Password protected lesson code
        $correctpass = false;
        if (!empty($userpassword) && (($lesson->password == md5(trim($userpassword))) || ($lesson->password == trim($userpassword)))) {
            // with or without md5 for backward compatibility (MDL-11090)
            $USER->lessonloggedin[$lesson->id] = true;
            if ($lesson->highscores) {
                // Logged in - redirect so we go through all of these checks before starting the lesson.
                redirect("$CFG->wwwroot/mod/lesson/view.php?id=$cm->id");
            }
        } else {
            echo $lessonoutput->header($lesson, $cm);
            echo $lessonoutput->login_prompt($lesson, $userpassword !== '');
            echo $lessonoutput->footer();
            exit();
        }
    }
}

// print the embedded media html code
echo $OUTPUT->box(lesson_get_media_html($lesson, $context));

if ($lesson->mediaclose) {
   echo '<div class="lessonmediafilecontrol">';
   echo $OUTPUT->close_window_button();
   echo '</div>';
}

echo $lessonoutput->footer();
