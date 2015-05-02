<?php

/**
 * Plugin capabilities.
 *
 * @package    repository_flickr
 * @copyright  2009 Dongsheng Cai
 * @author     Dongsheng Cai <dongsheng@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/flickr:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
