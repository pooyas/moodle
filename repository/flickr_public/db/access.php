<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_flickr_public
 * @copyright  2009 Dongsheng Cai
 * @author     2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/flickr_public:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
