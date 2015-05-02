<?php


/**
 * @package    core
 * @subpackage tag
 * @copyright  2007 Luiz Cruz <luiz.laydner@gmail.com>
 * 
 */

define('AJAX_SCRIPT', true);

require_once('../config.php');
require_once('lib.php');

if (empty($CFG->usetags)) {
    // Tags are disabled.
    die();
}

require_login(0, false);
if (isguestuser()) {
    // Guests should not be using this.
    die();
}

// If a user cannot edit tags, they cannot add related tags which is what this auto complete is for.
require_capability('lion/tag:edit', context_system::instance());

$query = optional_param('query', '', PARAM_TAG);

echo $OUTPUT->header();

// Limit the query to a minimum of 3 characters.
$similartags = array();
if (core_text::strlen($query) >= 3) {
    $similartags = tag_autocomplete($query);
}

foreach ($similartags as $tag) {
    echo clean_param($tag->name, PARAM_TAG) . "\t" . tag_display_name($tag) . "\n";
}

echo $OUTPUT->footer();
