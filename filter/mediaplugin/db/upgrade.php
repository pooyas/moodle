<?php


/**
 * Manual authentication plugin upgrade code
 *
 * @package    filter
 * @subpackage mediaplugin
 * @copyright  2015 Pooya Saeedi
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_filter_mediaplugin_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();


    if ($oldversion < 2011121200) {
        // Move all the media enable setttings that are now handled by core media renderer.
        foreach (array('html5video', 'html5audio', 'mp3', 'flv', 'wmp', 'qt', 'rm',
                'youtube', 'vimeo', 'swf') as $type) {
            $existingkey = 'filter_mediaplugin_enable_' . $type;
            if (array_key_exists($existingkey, $CFG)) {
                set_config('core_media_enable_' . $type, $CFG->{$existingkey});
                unset_config($existingkey);
            }
        }

        // Override setting for html5 to turn it on (previous default was off; because
        // of changes in the way fallbacks are handled, this is now unlikely to cause
        // a problem, and is required for mobile a/v support on non-Flash devices, so
        // this change is basically needed in order to maintain existing behaviour).
        set_config('core_media_enable_html5video', 1);
        set_config('core_media_enable_html5audio', 1);

        upgrade_plugin_savepoint(true, 2011121200, 'filter', 'mediaplugin');
    }

    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this


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
