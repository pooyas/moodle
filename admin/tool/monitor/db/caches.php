<?php

/**
 * Event monitor cache definitions.
 *
 * @package    tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi 
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
