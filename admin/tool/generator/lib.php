<?php

/**
 * Generator tool functions.
 *
 * @package    tool_generator
 * @copyright  David Monllaó
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Files support.
 *
 * Exits if the required permissions are not satisfied.
 *
 * @param stdClass $course course object
 * @param stdClass $cm
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return void The file is sent along with it's headers
 */
function tool_generator_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {

    // Only for admins or CLI.
    if (!defined('CLI_SCRIPT') && !is_siteadmin()) {
        die;
    }

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'tool_generator', $filearea, $args[0], '/', $args[1]);

    // Send the file, always forcing download, we don't want options.
    session_get_instance()->write_close();
    send_stored_file($file, 0, 0, true);
}

