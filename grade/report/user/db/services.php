<?php

/**
 * User grade report external functions and service definitions.
 *
 * @package    gradereport
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
 * 
 */

$functions = array(

    'gradereport_user_get_grades_table' => array(
        'classname' => 'gradereport_user_external',
        'methodname' => 'get_grades_table',
        'classpath' => 'grade/report/user/externallib.php',
        'description' => 'Get the user/s report grades table for a course',
        'type' => 'read',
        'capabilities' => 'gradereport/user:view'
    )
);
