<?php

/**
 * This file keeps track of upgrades to the self completion block
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
 * @subpackage selfcompletion
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Handles upgrading instances of this block.
 *
 * @param int $oldversion
 * @param object $block
 */
function xmldb_block_selfcompletion_upgrade($oldversion, $block) {
    global $DB;

    if ($oldversion < 2012112901) {
        // Get the instances of this block.
        if ($blocks = $DB->get_records('block_instances', array('blockname' => 'selfcompletion', 'pagetypepattern' => 'my-index'))) {
            // Loop through and remove them from the My Lion page.
            foreach ($blocks as $block) {
                blocks_delete_instance($block);
            }

        }

        // Savepoint reached.
        upgrade_block_savepoint(true, 2012112901, 'selfcompletion');
    }


    return true;
}