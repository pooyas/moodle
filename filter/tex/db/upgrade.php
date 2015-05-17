<?php


/**
 * TeX filter upgrade code.
 *
 * @package    filter
 * @subpackage tex
 * @copyright  2015 Pooya Saeedi
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_filter_tex_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();


    // Lion v2.3.0 release upgrade line
    // Put any upgrade step following this


    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this


    // Lion v2.5.0 release upgrade line.
    // Put any upgrade step following this.


    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2013120300) {
        $settings = array(
                'density', 'latexbackground', 'convertformat', 'pathlatex',
                'convertformat', 'pathconvert', 'pathdvips', 'latexpreamble');

        // Move tex settings to config_pluins and delete entries from the config table.
        foreach ($settings as $setting) {
            $existingkey = 'filter_tex_'.$setting;
            if (array_key_exists($existingkey, $CFG)) {
                set_config($setting, $CFG->{$existingkey}, 'filter_tex');
                unset_config($existingkey);
            }
        }

        upgrade_plugin_savepoint(true, 2013120300, 'filter', 'tex');
    }

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
