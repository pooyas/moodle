<?php

/**
 * Event observer.
 *
 * @package    block
 * @subpackage recent_activity
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$observers = array (
    array (
        'eventname' => '\core\event\course_module_created',
        'callback'  => 'block_recent_activity_observer::store',
        'internal'  => false, // This means that we get events only after transaction commit.
        'priority'  => 1000,
    ),
    array (
        'eventname' => '\core\event\course_module_updated',
        'callback'  => 'block_recent_activity_observer::store',
        'internal'  => false, // This means that we get events only after transaction commit.
        'priority'  => 1000,
    ),
    array (
        'eventname' => '\core\event\course_module_deleted',
        'callback'  => 'block_recent_activity_observer::store',
        'internal'  => false, // This means that we get events only after transaction commit.
        'priority'  => 1000,
    ),
);
