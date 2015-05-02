<?php

/**
 * Event monitor cache definitions.
 *
 * @package    tool_monitor
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

defined('LION_INTERNAL') || die;

$definitions = array(
    'eventsubscriptions' => array(
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true,
        'simpledata' => true,
        'staticacceleration' => true,
        'staticaccelerationsize' => 10
    )
);
