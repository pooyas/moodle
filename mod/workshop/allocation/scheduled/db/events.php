<?php


/**
 * Defines event handlers
 *
 * @package     workshopallocation_scheduled
 * @subpackage  mod_workshop
 * @category    event
 * @copyright   2013 David Mudrak <david@lion.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '\mod_workshop\event\course_module_viewed',
        'callback'  => '\workshopallocation_scheduled\observer::workshop_viewed',
    )
);
