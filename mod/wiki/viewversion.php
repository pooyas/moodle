<?php


/**
 * @package    mod
 * @subpackage wiki
 * @copyright  2015 Pooya Saeedi
*/

// This file is part of Lion - http://lion.org/
//
// Lion is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Lion is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Lion. If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains all necessary code to view an old version of a page
 *
 *
 *
 */

require_once('../../config.php');

require_once($CFG->dirroot . '/mod/wiki/lib.php');
require_once($CFG->dirroot . '/mod/wiki/locallib.php');
require_once($CFG->dirroot . '/mod/wiki/pagelib.php');

$pageid = required_param('pageid', PARAM_TEXT);
$versionid = required_param('versionid', PARAM_INT);

if (!$page = wiki_get_page($pageid)) {
    print_error('incorrectpageid', 'wiki');
}

if (!$subwiki = wiki_get_subwiki($page->subwikiid)) {
    print_error('incorrectsubwikiid', 'wiki');
}

if (!$wiki = wiki_get_wiki($subwiki->wikiid)) {
    print_error('incorrectwikiid', 'wiki');
}

if (!$cm = get_coursemodule_from_instance('wiki', $wiki->id)) {
    print_error('invalidcoursemodule');
}

$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

require_login($course, true, $cm);

if (!wiki_user_can_view($subwiki, $wiki)) {
    print_error('cannotviewpage', 'wiki');
}

$wikipage = new page_wiki_viewversion($wiki, $subwiki, $cm);

$wikipage->set_page($page);
$wikipage->set_versionid($versionid);

$event = \mod_wiki\event\page_version_viewed::create(
        array(
            'context' => context_module::instance($cm->id),
            'objectid' => $pageid,
            'other' => array(
                'versionid' => $versionid
                )
            ));
$event->add_record_snapshot('wiki_pages', $page);
$event->add_record_snapshot('wiki', $wiki);
$event->add_record_snapshot('wiki_subwikis', $subwiki);
$event->trigger();

// Print the page header
$wikipage->print_header();
$wikipage->print_content();

$wikipage->print_footer();
