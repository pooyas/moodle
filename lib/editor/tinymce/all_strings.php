<?php

/**
 * On-the-fly conversion of Lion lang strings to TinyMCE expected JS format.
 *
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
 * 
 */

define('NO_LION_COOKIES', true);
define('NO_UPGRADE_CHECK', true);

require('../../../config.php');
require_once("$CFG->dirroot/lib/jslib.php");
require_once("$CFG->dirroot/lib/configonlylib.php");

$lang  = optional_param('elanguage', 'en', PARAM_SAFEDIR);
$rev   = optional_param('rev', -1, PARAM_INT);

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/lib/editor/tinymce/extra/strings.php');

if (!get_string_manager()->translation_exists($lang, false)) {
    $lang = 'en';
    $rev = -1; // Do not cache missing langs.
}

$candidate = "$CFG->cachedir/editor_tinymce/$rev/$lang.js";
$etag = sha1("$lang/$rev");

if ($rev > -1 and file_exists($candidate)) {
    if (!empty($_SERVER['HTTP_IF_NONE_MATCH']) || !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        // we do not actually need to verify the etag value because our files
        // never change in cache because we increment the rev parameter
        js_send_unmodified(filemtime($candidate), $etag);
    }
    js_send_cached($candidate, $etag, 'all_strings.php');
}

$string = get_string_manager()->load_component_strings('editor_tinymce', $lang);

// Process the $strings to match expected tinymce lang array structure.
$result = array();

foreach ($string as $key=>$value) {
    $parts = explode(':', $key);
    if (count($parts) != 2) {
        // Ignore non-TinyMCE strings.
        continue;
    }

    $result[$parts[0]][$parts[1]] = $value;
}

// Add subplugin strings, accept only those with proper pluginname prefix with colon.
foreach (core_component::get_plugin_list('tinymce') as $component => $ignored) {
    $componentstrings = get_string_manager()->load_component_strings(
            'tinymce_' . $component, $lang);
    foreach ($componentstrings as $key => $value) {
        if (strpos($key, "$component:") !== 0 and strpos($key, $component.'_dlg:') !== 0) {
            // Ignore normal lang strings.
            continue;
        }
        $parts = explode(':', $key);
        if (count($parts) != 2) {
            // Ignore malformed strings with more colons.
            continue;
        }
        $component = $parts[0];
        $string = $parts[1];
        $result[$component][$string] = $value;
    }
}

$output = 'tinyMCE.addI18n({'.$lang.':'.json_encode($result).'});';

if ($rev > -1) {
    js_write_cache_file_content($candidate, $output);
    // verify nothing failed in cache file creation
    clearstatcache();
    if (file_exists($candidate)) {
        js_send_cached($candidate, $etag, 'all_strings.php');
    }
}

js_send_uncached($output, 'all_strings.php');
