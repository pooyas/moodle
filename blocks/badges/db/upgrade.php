<?php

/**
 * This file keeps track of upgrades to the badges block
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
 * @since Lion 2.8
 * @package block_badges
 * @copyright 2014 Andrew Davis
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade the badges block
 * @param int $oldversion
 * @param object $block
 */
function xmldb_block_badges_upgrade($oldversion, $block) {
    global $DB;

    if ($oldversion < 2014062600) {
        // Add this block the default blocks on /my.
        $blockname = 'badges';

        // Do not try to add the block if we cannot find the default my_pages entry.
        // Private => 1 refers to MY_PAGE_PRIVATE.
        if ($systempage = $DB->get_record('my_pages', array('userid' => null, 'private' => 1))) {
            $page = new lion_page();
            $page->set_context(context_system::instance());

            // Check to see if this block is already on the default /my page.
            $criteria = array(
                'blockname' => $blockname,
                'parentcontextid' => $page->context->id,
                'pagetypepattern' => 'my-index',
                'subpagepattern' => $systempage->id,
            );

            if (!$DB->record_exists('block_instances', $criteria)) {
                // Add the block to the default /my.
                $page->blocks->add_region(BLOCK_POS_RIGHT);
                $page->blocks->add_block($blockname, BLOCK_POS_RIGHT, 0, false, 'my-index', $systempage->id);
            }
        }

        upgrade_block_savepoint(true, 2014062600, $blockname);
    }

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
