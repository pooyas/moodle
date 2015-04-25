<?php

/**
 * This file is the admin frontend to execute all the checks available
 * in the environment.xml file. It includes database, php and
 * php_extensions. 
 *
 * @package    core
 * @subpackage admin
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/environmentlib.php');
require_once($CFG->libdir.'/componentlib.class.php');

// Parameters
$action  = optional_param('action', '', PARAM_ALPHANUMEXT);
$version = optional_param('version', '', PARAM_FILE); //

$extraurlparams = array();
if ($version) {
    $extraurlparams['version'] = $version;
}
admin_externalpage_setup('environment', '', $extraurlparams);

// Handle the 'updatecomponent' action
// COMMENTOUT (Pooya)
// We don't want it to connect anywhere for now
// if ($action == 'updatecomponent' && confirm_sesskey()) {
//     // Create component installer and execute it
//     if ($cd = new component_installer('https://download.moodle.org',
//                                       'environment',
//                                       'environment.zip')) {
//         $status = $cd->install(); //returns COMPONENT_(ERROR | UPTODATE | INSTALLED)
//         switch ($status) {
//             case COMPONENT_ERROR:
//                 if ($cd->get_error() == 'remotedownloaderror') {
//                     $a = new stdClass();
//                     $a->url  = 'https://download.moodle.org/environment/environment.zip';
//                     $a->dest = $CFG->dataroot . '/';
//                     print_error($cd->get_error(), 'error', $PAGE->url, $a);
//                     die();

//                 } else {
//                     print_error($cd->get_error(), 'error', $PAGE->url);
//                     die();
//                 }

//             case COMPONENT_UPTODATE:
//                 redirect($PAGE->url, get_string($cd->get_error(), 'error'));
//                 die;

//             case COMPONENT_INSTALLED:
//                 redirect($PAGE->url, get_string('componentinstalled', 'admin'));
//                 die;
//         }
//     }
// }

// Get current Lion version
$current_version = $CFG->release;

// Calculate list of versions
$versions = array();
if ($contents = load_environment_xml()) {
    if ($env_versions = get_list_of_environment_versions($contents)) {
        // Set the current version at the beginning
        $env_version = normalize_version($current_version); //We need this later (for the upwards)
        $versions[$env_version] = $current_version;
        // If no version has been previously selected, default to $current_version
        if (empty($version)) {
            $version =  $env_version;
        }
        //Iterate over each version, adding bigger than current
        foreach ($env_versions as $env_version) {
            if (version_compare(normalize_version($current_version), $env_version, '<')) {
                $versions[$env_version] = $env_version;
            }
        }
        // Add 'upwards' to the last element
        $versions[$env_version] = $env_version.' '.get_string('upwards', 'admin');
    } else {
        $versions = array('error' => get_string('error'));
    }
}

// Get the results of the environment check.
// @todo: dig in check_moodle_environment
list($envstatus, $environment_results) = check_moodle_environment($version, ENV_SELECT_NEWER);

// Display the page.
$output = $PAGE->get_renderer('core', 'admin');
echo $output->environment_check_page($versions, $version, $envstatus, $environment_results);
