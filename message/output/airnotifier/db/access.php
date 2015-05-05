<?php

/**
 * Capability definitions for airnotifier.
 *
 * @package   message_airnotifier
 * @category  access
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'message/airnotifier:managedevice' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
