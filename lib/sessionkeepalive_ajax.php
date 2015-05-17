<?php


/**
 * Ensure that session is kept alive.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);
require_once(dirname(__DIR__) . '/config.php');

// Require the session key - want to make sure that this isn't called
// maliciously to keep a session alive longer than intended.
if (!confirm_sesskey()) {
    header('HTTP/1.1 403 Forbidden');
    print_error('invalidsesskey');
}

// Update the session.
\core\session\manager::touch_session(session_id());
