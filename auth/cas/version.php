<?php


/**
 * Version details
 *
 * @package    auth
 * @subpackage cas
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'auth_cas';        // Full name of the plugin (used for diagnostics)

$plugin->dependencies = array('auth_ldap' => 2014110400);
