<?php


/**
 * Spellchecker post install script.
 *
 * @package    editor
 * @subpackage tinymce
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

function xmldb_tinymce_spellchecker_install() {
    global $CFG, $DB;
    require_once(__DIR__.'/upgradelib.php');

    tinymce_spellchecker_migrate_settings();
}
