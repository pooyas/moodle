<?php

/**
 * Provides A/V preview features for the TinyMCE editor Lion Media plugin.
 * The preview is included in an iframe within the popup dialog.
 *
 * @package   tinymce
 * @subpackage lionmedia
 * @copyright 2015 Pooya Saeedi
 * 
 */

require(dirname(__FILE__) . '/../../../../../config.php');
require_once($CFG->libdir . '/filelib.php');

// Decode the url - it can not be passed around unencoded because security filters might block it.
$media = required_param('media', PARAM_RAW);
$media = base64_decode($media);
$url = clean_param($media, PARAM_URL);
$url = new lion_url($url);

// Now output this file which is super-simple
$PAGE->set_pagelayout('embedded');
$PAGE->set_url(new lion_url('/lib/editor/tinymce/plugins/lionmedia/preview.php'));
$PAGE->set_context(context_system::instance());
$PAGE->add_body_class('core_media_preview');

echo $OUTPUT->header();

$mediarenderer = $PAGE->get_renderer('core', 'media');

if (isloggedin() and !isguestuser() and $mediarenderer->can_embed_url($url)) {
    require_sesskey();
    echo $mediarenderer->embed_url($url);
} else {
    print_string('nopreview', 'tinymce_lionmedia');
}

echo $OUTPUT->footer();
