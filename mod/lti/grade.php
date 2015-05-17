<?php


/**
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
*/

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
 * This file contains submissions-specific code for the lti module
 *
 *  marc.alier@upc.edu
 * @deprecated since 2.8
 */

require_once(dirname(dirname(__DIR__)).'/config.php');

$id = optional_param('id', 0, PARAM_INT);
$l  = optional_param('l', 0, PARAM_INT);

if ($l) {
    $lti = $DB->get_record('lti', array('id' => $l), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('lti', $lti->id, $lti->course, false, MUST_EXIST);
} else {
    $cm = get_coursemodule_from_id('lti', $id, 0, false, MUST_EXIST);
    $lti = $DB->get_record('lti', array('id' => $cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, false, $cm);
require_capability('mod/lti:view', context_module::instance($cm->id));

debugging('This file has been deprecated.  Links to this file should automatically '.
    'fallback to /mod/lti/view.php once this file has been deleted.', DEBUG_DEVELOPER);

redirect(new lion_url('/mod/lti/view.php', array('l' => $lti->id)));
