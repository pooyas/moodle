<?php

/**
 * Definition of core event observers.
 *
 * The observers defined in this file are notified when respective events are triggered. All plugins
 * support this.
 *
 * For more information, take a look to the documentation available:
 *     - Events API: {@link http://docs.lion.org/dev/Event_2}
 *     - Upgrade API: {@link http://docs.lion.org/dev/Upgrade_API}
 *
 * @package   core
 * @category  event
 * @copyright 2007 onwards Martin Dougiamas  http://dougiamas.com
 * 
 */

defined('LION_INTERNAL') || die();

// List of legacy event handlers.

$handlers = array(
    // No more old events!
);

// List of events_2 observers.

$observers = array(

    array(
        'eventname'   => '\core\event\course_module_completion_updated',
        'callback'    => 'core_badges_observer::course_module_criteria_review',
    ),
    array(
        'eventname'   => '\core\event\course_completed',
        'callback'    => 'core_badges_observer::course_criteria_review',
    ),
    array(
        'eventname'   => '\core\event\user_updated',
        'callback'    => 'core_badges_observer::profile_criteria_review',
    )

);

// List of all events triggered by Lion can be found using Events list report.
