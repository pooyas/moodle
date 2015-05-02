<?php

/**
 * Capabilities for equella repository.
 *
 * @package    repository_equella
 * @copyright  2012 Dongsheng Cai {@link http://dongsheng.org}
 * @author     Dongsheng Cai <dongsheng@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$capabilities = array(
    'repository/equella:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);
