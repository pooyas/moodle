<?php

/**
 * This page allows instructors to configure course level tool providers.
 *
 * @package mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/lti/edit_form.php');

$courseid = required_param('course', PARAM_INT);

require_login($courseid, false);
$url = new lion_url('/mod/lti/instructor_edit_tool_type.php');
$PAGE->set_url($url);
$PAGE->set_pagelayout('popup');

$action = optional_param('action', null, PARAM_TEXT);
$typeid = optional_param('typeid', null, PARAM_INT);

require_sesskey();

require_capability('mod/lti:addcoursetool', context_course::instance($courseid));

if (!empty($typeid)) {
    $type = lti_get_type($typeid);
    if ($type->course != $courseid) {
        throw new Exception('You do not have permissions to edit this tool type.');
        die;
    }
}

$form = new mod_lti_edit_types_form();
if ($data = $form->get_data()) {
    $type = new stdClass();

    if (!empty($typeid)) {
        $type->id = $typeid;
        $name = json_encode($data->lti_typename);

        lti_update_type($type, $data);

        $fromdb = lti_get_type($typeid);
        $json = json_encode($fromdb);

        // Output script to update the calling window.
        $script = "
            <html>
                <script type=\"text/javascript\">
                    window.opener.M.mod_lti.editor.updateToolType({$json});
                    window.close();
                </script>
            </html>
        ";

        echo $script;
        die;
    } else {
        $type->state = LTI_TOOL_STATE_CONFIGURED;
        $type->course = $COURSE->id;

        $id = lti_add_type($type, $data);

        $fromdb = lti_get_type($id);
        $json = json_encode($fromdb);

        // Output script to update the calling window.
        $script = "
            <html>
                <script type=\"text/javascript\">
                    window.opener.M.mod_lti.editor.addToolType({$json});
                    window.close();
                </script>
            </html>
        ";

        echo $script;

        die;
    }
} else if ($form->is_cancelled()) {
    $script = "
        <html>
            <script type=\"text/javascript\">
                window.close();
            </script>
        </html>
    ";

    echo $script;
    die;
}

// Delete action is called via ajax.
if ($action == 'delete') {
    lti_delete_type($typeid);
    die;
}

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('toolsetup', 'lti'));

if ($action == 'add') {
    $form->display();
} else if ($action == 'edit') {
    $type = lti_get_type_type_config($typeid);
    $form->set_data($type);
    $form->display();
}

echo $OUTPUT->footer();
