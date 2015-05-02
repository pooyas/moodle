<?php



/**
 * Tabs to be included on the pages for configuring a single host
 * $mnet_peer object must be set and bootstrapped
 * $currenttab string must be set
 *
 * @package    core
 * @subpackage mnet
 * @copyright  2007 Donal McMullan
 * @copyright  2007 Martin Langhoff
 * @copyright  2010 Penny Leach
 * 
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.'); // It must be included from a Lion page
}

$strmnetservices   = get_string('mnetservices', 'mnet');
$strmnetedithost   = get_string('reviewhostdetails', 'mnet');

$tabs = array();
if (isset($mnet_peer->id) && $mnet_peer->id > 0) {
    $tabs[] = new tabobject('mnetdetails', 'peers.php?step=update&amp;hostid='.$mnet_peer->id, $strmnetedithost, $strmnetedithost, false);
    $tabs[] = new tabobject('mnetservices', 'services.php?hostid='.$mnet_peer->id, $strmnetservices, $strmnetservices, false);
    $tabs[] = new tabobject('mnetprofilefields', 'profilefields.php?hostid=' . $mnet_peer->id, get_string('profilefields', 'mnet'), get_string('profilefields', 'mnet'), false);
} else {
    $tabs[] = new tabobject('mnetdetails', '#', $strmnetedithost, $strmnetedithost, false);
}
print_tabs(array($tabs), $currenttab);
