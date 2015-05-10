<?php

/**
 * This file contains all necessary code to get a printable version of a wiki page
 *
 * @package mod
 * @subpackage wiki
 * @copyright 2015 Pooya Saeedi
 *
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/wiki/lib.php');
require_once($CFG->dirroot . '/mod/wiki/locallib.php');
require_once($CFG->dirroot . '/mod/wiki/pagelib.php');

$pageid = required_param('pageid', PARAM_INT); // Page ID

if (!$page = wiki_get_page($pageid)) {
    print_error('incorrectpageid', 'wiki');
}
if (!$subwiki = wiki_get_subwiki($page->subwikiid)) {
    print_error('incorrectsubwikiid', 'wiki');
}
if (!$cm = get_coursemodule_from_instance("wiki", $subwiki->wikiid)) {
    print_error('invalidcoursemodule');
}
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
if (!$wiki = wiki_get_wiki($subwiki->wikiid)) {
    print_error('incorrectwikiid', 'wiki');
}

require_login($course, true, $cm);

if (!wiki_user_can_view($subwiki, $wiki)) {
    print_error('cannotviewpage', 'wiki');
}

$wikipage = new page_wiki_prettyview($wiki, $subwiki, $cm);

$wikipage->set_page($page);

$context = context_module::instance($cm->id);
$event = \mod_wiki\event\page_viewed::create(
        array(
            'context' => $context,
            'objectid' => $pageid,
            'other' => array('prettyview' => true)
            )
        );
$event->add_record_snapshot('wiki_pages', $page);
$event->add_record_snapshot('wiki', $wiki);
$event->add_record_snapshot('wiki_subwikis', $subwiki);
$event->trigger();

$wikipage->print_header();
$wikipage->print_content();
$wikipage->print_footer();
