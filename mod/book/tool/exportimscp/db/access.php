<?php

/**
 * Book module capability definition
 *
 * @package    booktool_exportimscp
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die;

$capabilities = array(
    'booktool/exportimscp:export' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE
    ),
);
