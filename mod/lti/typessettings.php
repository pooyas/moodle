<?php
//
// This file is part of BasicLTI4Lion
//
// BasicLTI4Lion is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for Lion 1.9 and Lion 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for Lion. Lion is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4Lion is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for Lion is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4Lion is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu.

/**
 * This file contains the script used to clone Lion admin setting page.
 *
 * It is used to create a new form used to pre-configure lti activities
 *
 * @package mod_lti
 * @copyright  2009 Marc Alier, Jordi Piguillem, Nikolas Galanis
 *  marc.alier@upc.edu
 * @copyright  2009 Universitat Politecnica de Catalunya http://www.upc.edu
 * @author     Marc Alier
 * @author     Jordi Piguillem
 * @author     Nikolas Galanis
 * @author     Chris Scribner
 * 
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/mod/lti/edit_form.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$action       = optional_param('action', null, PARAM_ALPHANUMEXT);
$id           = optional_param('id', null, PARAM_INT);
$tab          = optional_param('tab', '', PARAM_ALPHAEXT);

// No guest autologin.
require_login(0, false);

require_sesskey();

// Check this is not for a tool created from a tool proxy.
if (!empty($id)) {
    $type = lti_get_type_type_config($id);
    if (!empty($type->toolproxyid)) {
        $sesskey = required_param('sesskey', PARAM_RAW);
        $redirect = new lion_url('/mod/lti/toolssettings.php',
            array('action' => $action, 'id' => $id, 'sesskey' => $sesskey, 'tab' => $tab));
        redirect($redirect);
    }
} else {
    $type = new stdClass();
}

$pageurl = new lion_url('/mod/lti/typessettings.php');
if (!empty($id)) {
    $pageurl->param('id', $id);
}
$PAGE->set_url($pageurl);

admin_externalpage_setup('managemodules'); // Hacky solution for printing the admin page.

$redirect = "$CFG->wwwroot/$CFG->admin/settings.php?section=modsettinglti&tab={$tab}";

if ($action == 'accept') {
    lti_set_state_for_type($id, LTI_TOOL_STATE_CONFIGURED);
    redirect($redirect);
} else if ($action == 'reject') {
    lti_set_state_for_type($id, LTI_TOOL_STATE_REJECTED);
    redirect($redirect);
} else if ($action == 'delete') {
    lti_delete_type($id);
    redirect($redirect);
}

$form = new mod_lti_edit_types_form($pageurl, (object)array('isadmin' => true, 'istool' => false));

if ($data = $form->get_data()) {
    $type = new stdClass();
    if (!empty($id)) {
        $type->id = $id;
        lti_update_type($type, $data);

        redirect($redirect);
    } else {
        $type->state = LTI_TOOL_STATE_CONFIGURED;
        lti_add_type($type, $data);

        redirect($redirect);
    }
} else if ($form->is_cancelled()) {
    redirect($redirect);
}

$PAGE->set_title("$SITE->shortname: " . get_string('toolsetup', 'lti'));
$PAGE->navbar->add(get_string('lti_administration', 'lti'), $CFG->wwwroot.'/'.$CFG->admin.'/settings.php?section=modsettinglti');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('toolsetup', 'lti'));
echo $OUTPUT->box_start('generalbox');

if ($action == 'update') {
    $form->set_data($type);
}

$form->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
