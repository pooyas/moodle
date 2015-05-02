<?php

/**
 * Wrapper script redirecting user operations to correct destination.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_user
 */

require_once("../config.php");

$formaction = required_param('formaction', PARAM_FILE);
$id = required_param('id', PARAM_INT);

$PAGE->set_url('/user/action_redir.php', array('formaction' => $formaction, 'id' => $id));

// Add every page will be redirected by this script.
$actions = array(
        'messageselect.php',
        'addnote.php',
        'groupaddnote.php',
        );

if (array_search($formaction, $actions) === false) {
    print_error('unknownuseraction');
}

if (!confirm_sesskey()) {
    print_error('confirmsesskeybad');
}

require_once($formaction);
