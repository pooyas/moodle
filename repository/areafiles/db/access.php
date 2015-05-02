<?php

/**
 * Plugin capabilities for repository_areafiles
 *
 * @package    repository_areafiles
 * @copyright  2013 Marina Glancy
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/areafiles:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
