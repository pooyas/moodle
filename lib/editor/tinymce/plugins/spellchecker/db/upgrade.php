<?php

/**
 * Spellchecker upgrade script.
 *
 * @package   tinymce_spellchecker
 * @copyright 2012 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

function xmldb_tinymce_spellchecker_upgrade($oldversion) {
    global $CFG, $DB;
    require_once(__DIR__.'/upgradelib.php');

    $dbman = $DB->get_manager();

    if ($oldversion < 2012051800) {
        tinymce_spellchecker_migrate_settings();
        upgrade_plugin_savepoint(true, 2012051800, 'tinymce', 'spellchecker');
    }


    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this


    // Lion v2.5.0 release upgrade line.
    // Put any upgrade step following this.


    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
