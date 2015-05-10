<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_user
 * @copyright  2010 Dongsheng Cai
 * @author     2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/user:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
