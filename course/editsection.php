<?php



/**
 * Edit the section basic information and availability
 *
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 */

require_once("../config.php");
require_once("lib.php");
require_once($CFG->libdir . '/formslib.php');

$id = required_param('id', PARAM_INT);    // course_sections.id
$sectionreturn = optional_param('sr', 0, PARAM_INT);
$deletesection = optional_param('delete', 0, PARAM_BOOL);

$PAGE->set_url('/course/editsection.php', array('id'=>$id, 'sr'=> $sectionreturn));

$section = $DB->get_record('course_sections', array('id' => $id), '*', MUST_EXIST);
$course = $DB->get_record('course', array('id' => $section->course), '*', MUST_EXIST);
$sectionnum = $section->section;

require_login($course);
$context = context_course::instance($course->id);
require_capability('lion/course:update', $context);

// Get section_info object with all availability options.
$sectioninfo = get_fast_modinfo($course)->get_section_info($sectionnum);

// Deleting the section.
if ($deletesection) {
    $cancelurl = course_get_url($course, $sectioninfo, array('sr' => $sectionreturn));
    if (course_can_delete_section($course, $sectioninfo)) {
        $confirm = optional_param('confirm', false, PARAM_BOOL) && confirm_sesskey();
        if ($confirm) {
            course_delete_section($course, $sectioninfo, true);
            $courseurl = course_get_url($course, 0, array('sr' => $sectionreturn));
            redirect($courseurl);
        } else {
            if (get_string_manager()->string_exists('deletesection', 'format_' . $course->format)) {
                $strdelete = get_string('deletesection', 'format_' . $course->format);
            } else {
                $strdelete = get_string('deletesection');
            }
            $PAGE->navbar->add($strdelete);
            $PAGE->set_title($strdelete);
            $PAGE->set_heading($course->fullname);
            echo $OUTPUT->header();
            echo $OUTPUT->box_start('noticebox');
            $optionsyes = array('id' => $id, 'confirm' => 1, 'delete' => 1, 'sesskey' => sesskey());
            $deleteurl = new lion_url('/course/editsection.php', $optionsyes);
            $formcontinue = new single_button($deleteurl, get_string('continue'));
            $formcancel = new single_button($cancelurl, get_string('cancel'), 'get');
            echo $OUTPUT->confirm(get_string('confirmdeletesection', '',
                get_section_name($course, $sectioninfo)), $formcontinue, $formcancel);
            echo $OUTPUT->box_end();
            echo $OUTPUT->footer();
            exit;
        }
    } else {
        notice(get_string('nopermissions', 'error', get_string('deletesection')), $cancelurl);
    }
}

$editoroptions = array('context'=>$context ,'maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'noclean'=>true);
$mform = course_get_format($course->id)->editsection_form($PAGE->url,
        array('cs' => $sectioninfo, 'editoroptions' => $editoroptions));
// set current value, make an editable copy of section_info object
// this will retrieve all format-specific options as well
$initialdata = convert_to_array($sectioninfo);
if (!empty($CFG->enableavailability)) {
    $initialdata['availabilityconditionsjson'] = $sectioninfo->availability;
}
$mform->set_data($initialdata);

if ($mform->is_cancelled()){
    // Form cancelled, return to course.
    redirect(course_get_url($course, $section, array('sr' => $sectionreturn)));
} else if ($data = $mform->get_data()) {
    // Data submitted and validated, update and return to course.

    // For consistency, we set the availability field to 'null' if it is empty.
    if (!empty($CFG->enableavailability)) {
        // Renamed field.
        $data->availability = $data->availabilityconditionsjson;
        unset($data->availabilityconditionsjson);
        if ($data->availability === '') {
            $data->availability = null;
        }
    }
    $DB->update_record('course_sections', $data);
    rebuild_course_cache($course->id, true);
    if (isset($data->section)) {
        // Usually edit form does not change relative section number but just in case.
        $sectionnum = $data->section;
    }
    course_get_format($course->id)->update_section_format_options($data);

    // Set section info, as this might not be present in form_data.
    if (!isset($data->section))  {
        $data->section = $sectionnum;
    }
    // Trigger an event for course section update.
    $event = \core\event\course_section_updated::create(
            array(
                'objectid' => $data->id,
                'courseid' => $course->id,
                'context' => $context,
                'other' => array('sectionnum' => $data->section)
            )
        );
    $event->trigger();

    $PAGE->navigation->clear_cache();
    redirect(course_get_url($course, $section, array('sr' => $sectionreturn)));
}

// The edit form is displayed for the first time or if there was validation error on the previous step.
$sectionname  = get_section_name($course, $sectionnum);
$stredit      = get_string('edita', '', " $sectionname");
$strsummaryof = get_string('summaryof', '', " $sectionname");

$PAGE->set_title($stredit);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($stredit);
echo $OUTPUT->header();

echo $OUTPUT->heading($strsummaryof);

$mform->display();
echo $OUTPUT->footer();
