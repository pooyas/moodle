<?php



/**
 * Allows admin to configure licenses.
 * @package    core
 * @subpackage admin
 * @copyright  2015 Pooya Saeedi
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/licenselib.php');

require_login();
require_capability('lion/site:config', context_system::instance());

$returnurl = "$CFG->wwwroot/$CFG->admin/settings.php?section=managelicenses";

$action = optional_param('action', '', PARAM_ALPHANUMEXT);
$license = optional_param('license', '', PARAM_SAFEDIR);

////////////////////////////////////////////////////////////////////////////////
// process actions

if (!confirm_sesskey()) {
    redirect($returnurl);
}

$return = true;
switch ($action) {
    case 'disable':
        license_manager::disable($license);
        break;

    case 'enable':
        license_manager::enable($license);
        break;

    default:
        break;
}

if ($return) {
    redirect ($returnurl);
}
