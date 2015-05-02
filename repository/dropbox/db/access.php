<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_dropbox
 * @copyright  2010 Dongsheng Cai
 * @author     Dongsheng Cai <dongsheng@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/dropbox:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
