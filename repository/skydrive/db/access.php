<?php

/**
 * Capability definitions for skydrive repository
 *
 * @package    repository_skydrive
 * @copyright  2012 Lancaster University Network Services Ltd
 * @author     Dan Poltawski <dan.poltawski@luns.net.uk>
 * 
 */
$capabilities = array(
    'repository/skydrive:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
