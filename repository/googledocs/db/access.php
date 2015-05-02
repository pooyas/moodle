<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_googledocs
 * @copyright  2009 Dan Poltawski <talktodan@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/googledocs:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
