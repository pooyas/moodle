<?php

/**
 * Event observer.
 *
 * @package    tool
 * @subpackage log
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '*',
        'callback'  => '\tool_log\log\observer::store',
        'internal'  => false, // This means that we get events only after transaction commit.
        'priority'  => 1000,
    ),
);
