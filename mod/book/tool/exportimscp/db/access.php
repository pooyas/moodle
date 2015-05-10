<?php

/**
 * Book module capability definition
 *
 * @package    booktool
 * @subpackage exportimscp
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
