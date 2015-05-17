<?php


/**
 * My Lion -- a user's personal dashboard
 *
 * This file contains common functions for the dashboard and profile pages.
 *
 * @package    core
 * @subpackage my
 * @copyright  2015 Pooya Saeedi
 */

define('MY_PAGE_PUBLIC', 0);
define('MY_PAGE_PRIVATE', 1);

require_once("$CFG->libdir/blocklib.php");

/*
 * For a given user, this returns the $page information for their My Lion page
 *
 */
function my_get_page($userid, $private=MY_PAGE_PRIVATE) {
    global $DB, $CFG;

    if (empty($CFG->forcedefaultmylion) && $userid) {  // Ignore custom My Lion pages if admin has forced them
        // Does the user have their own page defined?  If so, return it.
        if ($customised = $DB->get_record('my_pages', array('userid' => $userid, 'private' => $private))) {
            return $customised;
        }
    }

    // Otherwise return the system default page
    return $DB->get_record('my_pages', array('userid' => null, 'name' => '__default', 'private' => $private));
}


/*
 * This copies a system default page to the current user
 *
 */
function my_copy_page($userid, $private=MY_PAGE_PRIVATE, $pagetype='my-index') {
    global $DB;

    if ($customised = $DB->record_exists('my_pages', array('userid' => $userid, 'private' => $private))) {
        return $customised;  // We're done!
    }

    // Get the system default page
    if (!$systempage = $DB->get_record('my_pages', array('userid' => null, 'private' => $private))) {
        return false;  // error
    }

    // Clone the basic system page record
    $page = clone($systempage);
    unset($page->id);
    $page->userid = $userid;
    $page->id = $DB->insert_record('my_pages', $page);

    // Clone ALL the associated blocks as well
    $systemcontext = context_system::instance();
    $usercontext = context_user::instance($userid);

    $blockinstances = $DB->get_records('block_instances', array('parentcontextid' => $systemcontext->id,
                                                                'pagetypepattern' => $pagetype,
                                                                'subpagepattern' => $systempage->id));
    foreach ($blockinstances as $instance) {
        unset($instance->id);
        $instance->parentcontextid = $usercontext->id;
        $instance->subpagepattern = $page->id;
        $instance->id = $DB->insert_record('block_instances', $instance);
        $blockcontext = context_block::instance($instance->id);  // Just creates the context record
    }

    // FIXME: block position overrides should be merged in with block instance
    //$blockpositions = $DB->get_records('block_positions', array('subpage' => $page->name));
    //foreach($blockpositions as $positions) {
    //    $positions->subpage = $page->name;
    //    $DB->insert_record('block_positions', $tc);
    //}

    return $page;
}

/*
 * For a given user, this deletes their My Lion page and returns them to the system default.
 *
 * @param int $userid the id of the user whose page should be reset
 * @param int $private either MY_PAGE_PRIVATE or MY_PAGE_PUBLIC
 * @param string $pagetype either my-index or user-profile
 * @return mixed system page, or false on error
 */
function my_reset_page($userid, $private=MY_PAGE_PRIVATE, $pagetype='my-index') {
    global $DB, $CFG;

    $page = my_get_page($userid, $private);
    if ($page->userid == $userid) {
        $context = context_user::instance($userid);
        if ($blocks = $DB->get_records('block_instances', array('parentcontextid' => $context->id,
                'pagetypepattern' => $pagetype))) {
            foreach ($blocks as $block) {
                if (is_null($block->subpagepattern) || $block->subpagepattern == $page->id) {
                    blocks_delete_instance($block);
                }
            }
        }
        $DB->delete_records('my_pages', array('id' => $page->id));
    }

    // Get the system default page
    if (!$systempage = $DB->get_record('my_pages', array('userid' => null, 'private' => $private))) {
        return false; // error
    }
    return $systempage;
}

class my_syspage_block_manager extends block_manager {
    // HACK WARNING!
    // TODO: figure out a better way to do this
    /**
     * Load blocks using the system context, rather than the user's context.
     *
     * This is needed because the My Lion pages set the page context to the
     * user's context for access control, etc.  But the blocks for the system
     * pages are stored in the system context.
     */
    public function load_blocks($includeinvisible = null) {
        $origcontext = $this->page->context;
        $this->page->context = context_system::instance();
        parent::load_blocks($includeinvisible);
        $this->page->context = $origcontext;
    }
}
