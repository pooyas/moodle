<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_picasa
 * @copyright  2015 Pooya Saeedi
 * @author     Dan Poltawski <talktodan@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/picasa:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
