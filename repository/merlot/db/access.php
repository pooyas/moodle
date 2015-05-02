<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_merlot
 * @copyright  2009 Dongsheng Cai
 * @author     Dongsheng Cai <dongsheng@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/merlot:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
