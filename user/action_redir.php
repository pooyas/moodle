<?php


/**
 * Wrapper script redirecting user operations to correct destination.
 *
 * @package    core
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
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
