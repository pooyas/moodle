<?php

/**
 * Display the custom file type settings page.
 *
 * @package tool_filetypes
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('tool_filetypes');

// Page settings.
$title = get_string('pluginname', 'tool_filetypes');

$context = context_system::instance();
$PAGE->set_url(new \lion_url('/admin/tool/filetypes/index.php'));
$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($SITE->fullname. ': ' . $title);

$renderer = $PAGE->get_renderer('tool_filetypes');

// Is it restricted because set in config.php?
$restricted = array_key_exists('customfiletypes', $CFG->config_php_settings);

// Display the page.
echo $renderer->header();
echo $renderer->edit_table(get_mimetypes_array(), core_filetypes::get_deleted_types(),
        $restricted);
echo $renderer->footer();
