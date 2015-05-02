<?php

/**
 * Event observer.
 *
 * @package   tool_log
 * @category  event
 * @copyright 2013 Petr Skoda {@link http://skodak.org}
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
