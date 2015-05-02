<?php

/**
 * Self enrol plugin external functions and service definitions.
 *
 * @package   enrol_self
 * @copyright 2013 Rajesh Taneja <rajesh@lion.com>
 * 
 * @since     Lion 2.6
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
