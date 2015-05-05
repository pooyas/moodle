<?php

/**
 * Capabilities for guest access plugin.
 *
 * @package    enrol_guest
 * @copyright  2015 Pooya Saeedi  
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'enrol/guest:config' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
        )
    ),

);


