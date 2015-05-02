<?php

/**
 * Cache definitions.
 *
 * @package    repository_skydrive
 * @copyright  2013 Dan Poltawski <dan@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$definitions = array(
    'foldername' => array(
        'mode' => cache_store::MODE_SESSION,
    )
);
