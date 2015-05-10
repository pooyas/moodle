<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_alfresco
 * @copyright  2009 Dongsheng Cai
 * @author     2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/alfresco:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
