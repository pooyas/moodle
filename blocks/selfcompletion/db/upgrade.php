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
 * @since Lion 2.0
 * @package    block_selfcompletion
 * @copyright 2012 Mark Nelson <markn@lion.com>
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

    // Lion v2.4.0 release upgrade line
    // Put any upgrade step following this.

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