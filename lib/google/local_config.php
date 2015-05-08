<?php

/**
 * Basic configuration overwrite for Google API.
 *
 * @package   core
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();
global $CFG, $SITE;
require_once($CFG->libdir . '/weblib.php');
require_once($CFG->libdir . '/google/curlio.php');

make_temp_directory('googleapi');
$GoogleConfigTempDir = $CFG->tempdir . '/googleapi';

global $apiConfig;
$apiConfig = array(
    // Application name.
    'application_name' => 'Lion ' . $CFG->release,

    // Site name to show in the Google's OAuth 1 authentication screen.
    'site_name' => $SITE->fullname,

    // Which HTTP IO classes to use.
    'ioClass' => 'lion_google_curlio',

    // Cache class directory, it should never be used but created just in case.
    'ioFileCache_directory' => $GoogleConfigTempDir,

    // Default Access Type for OAuth 2.0.
    'oauth2_access_type' => 'online',

    // Default Approval Prompt for OAuth 2.0.
    'oauth2_approval_prompt' => 'auto'
);
