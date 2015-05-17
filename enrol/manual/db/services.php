<?php


/**
 * Manual plugin external functions and service definitions.
 *
 * @category   webservice
 * @package    enrol
 * @subpackage manual
 * @copyright  2015 Pooya Saeedi
 */

$functions = array(

    // === enrol related functions ===
    'lion_enrol_manual_enrol_users' => array(
        'classname'   => 'lion_enrol_manual_external',
        'methodname'  => 'manual_enrol_users',
        'classpath'   => 'enrol/manual/externallib.php',
        'description' => 'DEPRECATED: this deprecated function will be removed in a future version. This function has be renamed as enrol_manual_enrol_users()',
        'capabilities'=> 'enrol/manual:enrol',
        'type'        => 'write',
    ),

    'enrol_manual_enrol_users' => array(
        'classname'   => 'enrol_manual_external',
        'methodname'  => 'enrol_users',
        'classpath'   => 'enrol/manual/externallib.php',
        'description' => 'Manual enrol users',
        'capabilities'=> 'enrol/manual:enrol',
        'type'        => 'write',
    ),

);
