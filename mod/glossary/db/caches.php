<?php

/**
 * Glossary cache definitions.
 *
 * @package    mod
 * @subpackage glossary
 * @category   cache
 * @copyright  2015 Pooya Saeedi
 * 
 */

$definitions = array(
    // This MUST NOT be a local cache, sorry cluster lovers.
    'concepts' => array(
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true, // The course id or 0 for global.
        'simpledata' => false,
        'staticacceleration' => true,
        'staticaccelerationsize' => 30,
    ),
);
