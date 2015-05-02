<?php

/**
 * Cache definitions.
 *
 * @package availability_grade
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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
