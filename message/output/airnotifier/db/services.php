<?php


/**
 * Airnotifier external functions and service definitions.
 *
 * @package    message
 * @subpackage airnotifier
 * @category   webservice
 * @copyright  2015 Pooya Saeedi
 * 
 */

$functions = array(
    'message_airnotifier_is_system_configured' => array(
        'classname'   => 'message_airnotifier_external',
        'methodname'  => 'is_system_configured',
        'classpath'   => 'message/output/airnotifier/externallib.php',
        'description' => 'Check whether the airnotifier settings have been configured',
        'type'        => 'read',
    ),

    'message_airnotifier_are_notification_preferences_configured' => array(
        'classname'   => 'message_airnotifier_external',
        'methodname'  => 'are_notification_preferences_configured',
        'classpath'   => 'message/output/airnotifier/externallib.php',
        'description' => 'Check if the users have notification preferences configured yet',
        'type'        => 'read',
    ),
);
