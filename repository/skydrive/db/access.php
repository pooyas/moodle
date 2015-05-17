<?php


/**
 * Capability definitions for skydrive repository
 *
 * @package    repository
 * @subpackage skydrive
 * @copyright  2015 Pooya Saeedi
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
