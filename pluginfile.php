<?php


/**
 * This script delegates file serving to individual plugins
 *
 * @package    core
 * @subpackage file
 * @copyright  2015 Pooya Saeedi 
 * 
 */

// Disable lion specific debug messages and any errors in output.
define('NO_DEBUG_DISPLAY', true);

require_once('config.php');
require_once('lib/filelib.php');

$relativepath = get_file_argument();
$forcedownload = optional_param('forcedownload', 0, PARAM_BOOL);
$preview = optional_param('preview', null, PARAM_ALPHANUM);

file_pluginfile($relativepath, $forcedownload, $preview);
