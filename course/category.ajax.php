<?php

/**
 * Helps lion-course-categoryexpander to serve AJAX requests
 *
 * @see core_course_renderer::coursecat_include_js()
 * @see core_course_renderer::coursecat_ajax()
 *
 * @package   core
 * @subpackage course
 * @copyright 2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);

require_once(dirname(__dir__) . '/config.php');

if ($CFG->forcelogin) {
    require_login();
}

$PAGE->set_context(context_system::instance());
$courserenderer = $PAGE->get_renderer('core', 'course');

echo json_encode($courserenderer->coursecat_ajax());
