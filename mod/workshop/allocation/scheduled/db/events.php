<?php



/**
 * Defines event handlers
 *
 * @category    event
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '\mod_workshop\event\course_module_viewed',
        'callback'  => '\workshopallocation_scheduled\observer::workshop_viewed',
    )
);
