<?php

/**
 * Book module capability definition
 *
 * @package    booktool_exportimscp
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die;

$capabilities = array(
    'booktool/exportimscp:export' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE
    ),
);
