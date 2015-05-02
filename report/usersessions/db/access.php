<?php

/**
 * Capabilities for this report.
 *
 * @package   report_usersessions
 * @copyright 2014 Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * 
 * @author    Petr Skoda <petr.skoda@totaralms.com>
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'report/usersessions:manageownsessions' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_USER,
        'archetypes' => array(
            'user' => CAP_ALLOW,
        ),

        // NOTE: shared accounts usually do not allow changing
        //       of own passwords, this is not very accurate but safer.
        'clonepermissionsfrom' => 'lion/user:changeownpassword'
    ),
);


