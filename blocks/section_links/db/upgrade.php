<?php

/**
 * This file keeps track of upgrades to the section links block
 *
 * Sometimes, changes between versions involve alterations to database structures
 * and other major things that may break installations.
 *
 * The upgrade function in this file will attempt to perform all the necessary
 * actions to upgrade your older installation to the current version.
 *
 * If there's something it cannot do itself, it will tell you what you need to do.
 *
 * The commands in here will all be database-neutral, using the methods of
 * database_manager class
 *
 * Please do not forget to use upgrade_set_timeout()
 * before any action that may take longer time to finish.
 *
 * @package    block
 * @subpackage section_links
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Upgrade code for the section links block.
 *
 * @global lion_database $DB
 * @param int $oldversion
 * @param object $block
 */
function xmldb_block_section_links_upgrade($oldversion, $block) {
    global $DB;


    if ($oldversion < 2013012200.00) {

        // The section links block used to use its own crazy plugin name.
        // Here we are converting it to the proper component name.
        $oldplugin = 'blocks/section_links';
        $newplugin = 'block_section_links';

        // Use the proper API here... thats what we should be doing as it ensures any caches etc are cleared
        // along the way!
        // It may be quicker to just write an SQL statement but that would be reckless.
        $config = get_config($oldplugin);
        if (!empty($config)) {
            foreach ($config as $name => $value) {
                set_config($name, $value, $newplugin);
                unset_config($name, $oldplugin);
            }
        }

        // Main savepoint reached.
        upgrade_block_savepoint(true, 2013012200.00, 'section_links');
    }


    return true;
}
