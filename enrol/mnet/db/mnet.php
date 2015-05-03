<?php

/**
 * This file contains the mnet services for the mnet enrolment plugin
 *
 * If we rewrite MNet as proposed in MDL-21993 this file would contain
 * just a declaration of xml-rpc methods that this plugin publishes.
 *
 * @since      Lion 2.0
 * @package    enrol_mnet
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$publishes = array(
    'mnet_enrol' => array(
        'apiversion' => 1,
        'classname'  => 'enrol_mnet_mnetservice_enrol',
        'filename'   => 'enrol.php',
        'methods'    => array(
            'available_courses',
            'user_enrolments',
            'enrol_user',
            'unenrol_user',
            'course_enrolments'
        ),
    ),
);
$subscribes = array(
    'mnet_enrol' => array(
        'available_courses' => 'enrol/mnet/enrol.php/available_courses',
        'user_enrolments'   => 'enrol/mnet/enrol.php/user_enrolments',
        'enrol_user'        => 'enrol/mnet/enrol.php/enrol_user',
        'unenrol_user'      => 'enrol/mnet/enrol.php/unenrol_user',
        'course_enrolments' => 'enrol/mnet/enrol.php/course_enrolments',
    ),
);
