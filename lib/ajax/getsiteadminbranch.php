<?php



/**
 * This file is used to deliver a branch from the site administration
 * in XML format back to a page from an AJAX call
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);
require_once(dirname(__FILE__) . '/../../config.php');

// This should be accessed by only valid logged in user.
if (!isloggedin() or isguestuser()) {
    die('Invalid access.');
}

// This identifies the type of the branch we want to get. Make sure it's SITE_ADMIN.
$branchtype = required_param('type', PARAM_INT);
if ($branchtype !== navigation_node::TYPE_SITE_ADMIN) {
    die('Wrong node type passed.');
}

// Start capturing output in case of broken plugins.
ajax_capture_output();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/lib/ajax/getsiteadminbranch.php', array('type'=>$branchtype));

$sitenavigation = new settings_navigation_ajax($PAGE);

// Convert and output the branch as JSON.
$converter = new navigation_json();
$branch = $sitenavigation->get('root');

ajax_check_captured_output();
echo $converter->convert($branch);
