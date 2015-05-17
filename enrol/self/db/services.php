<?php


/**
 * Self enrol plugin external functions and service definitions.
 *
 * @package    enrol
 * @subpackage self
 * @copyright  2015 Pooya Saeedi
 */

$functions = array(
    'enrol_self_get_instance_info' => array(
        'classname'   => 'enrol_self_external',
        'methodname'  => 'get_instance_info',
        'classpath'   => 'enrol/self/externallib.php',
        'description' => 'self enrolment instance information.',
        'type'        => 'read'
    )
);
