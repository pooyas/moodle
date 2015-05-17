<?php


/**
 * Version information for the ltiservice_toolsettings service.
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


$plugin->version   = 2014111000;
$plugin->requires  = 2014110400;
$plugin->component = 'ltiservice_toolsettings';
$plugin->dependencies = array(
    'ltiservice_profile' => 2014110400,
    'ltiservice_toolproxy' => 2014110400
);
