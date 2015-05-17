<?php


/**
 * Lion's lib to use for the Google API.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/weblib.php');

// Update the include_path so that the library can use require_once in its own files.
set_include_path(get_include_path() . PATH_SEPARATOR . $CFG->libdir . '/google');
require_once($CFG->libdir . '/google/Google/Client.php');
require_once($CFG->libdir . '/google/curlio.php');

/**
 * Wrapper to get a Google Client object.
 *
 * This automatically sets the config to Lion's defaults.
 *
 * @return Google_Client
 */
function get_google_client() {
    global $CFG, $SITE;

    make_temp_directory('googleapi');
    $tempdir = $CFG->tempdir . '/googleapi';

    $config = new Google_Config();
    $config->setApplicationName('Lion ' . $CFG->release);
    $config->setIoClass('lion_google_curlio');
    $config->setClassConfig('Google_Cache_File', 'directory', $tempdir);
    $config->setClassConfig('Google_Auth_OAuth2', 'access_type', 'online');
    $config->setClassConfig('Google_Auth_OAuth2', 'approval_prompt', 'auto');

    return new Google_Client($config);
}
