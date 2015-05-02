<?php

/**
 * Standard plugin entry points of the HTML question export format.
 *
 * @package   qformat_xhtml
 * @copyright 2013 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Serve question files when they are displayed in this export format.
 *
 * @param context $previewcontext the quiz context
 * @param int $questionid the question id.
 * @param context $filecontext the file (question) context
 * @param string $filecomponent the component the file belongs to.
 * @param string $filearea the file area.
 * @param array $args remaining file args.
 * @param bool $forcedownload.
 * @param array $options additional options affecting the file serving.
 */
function qformat_xhtml_question_preview_pluginfile($previewcontext, $questionid,
        $filecontext, $filecomponent, $filearea, $args, $forcedownload, $options = array()) {
    global $CFG;

    list($context, $course, $cm) = get_context_info_array($previewcontext->id);
    require_login($course, false, $cm);

    question_require_capability_on($questionid, 'view');

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/{$filecontext->id}/{$filecomponent}/{$filearea}/{$relativepath}";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        send_file_not_found();
    }

    send_stored_file($file, 0, 0, $forcedownload, $options);
}
