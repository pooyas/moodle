<?php

/**
 * Cache definitions.
 *
 * @package    availability
 * @subpackage grade
 * @copyright  2015 Pooya Saeedi
 * 
 */

$definitions = array(
    // Used to cache user grades for conditional availability purposes.
    'scores' => array(
        'mode' => cache_store::MODE_APPLICATION,
        'staticacceleration' => true,
        'staticaccelerationsize' => 2, // Should not be required for more than one user at a time.
        'ttl' => 3600,
    ),
    // Used to cache course grade items for conditional availability purposes.
    'items' => array(
        'mode' => cache_store::MODE_APPLICATION,
        'staticacceleration' => true,
        'staticaccelerationsize' => 2, // Should not be required for more than one course at a time.
        'ttl' => 3600,
    ),
);
