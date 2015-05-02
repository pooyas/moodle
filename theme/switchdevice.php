<?php

/**
 * This code processes switch device requests-> ... -> Theme selector UI.
 *
 * This script doesn't require login as not logged in users should still
 * be able to switch the device theme they are using.
 *
 * @package   core
 * 
 */

require('../config.php');

$url       = required_param('url', PARAM_LOCALURL);
$newdevice = required_param('device', PARAM_TEXT);

require_sesskey();

core_useragent::set_user_device_type($newdevice);

redirect($url);
