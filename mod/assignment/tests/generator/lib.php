<?php

/**
 * mod_assignment data generator
 *
 * @package    mod_assignment
 * @category   test
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * Assignment module data generator class
 *
 * @package    mod_assignment
 * @category   test
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */
class mod_assignment_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        $record = (object)(array)$record;

        if (!isset($record->assignmenttype)) {
            $record->assignmenttype = 'upload';
        }
        if (!isset($record->grade)) {
            $record->grade = 100;
        }
        if (!isset($record->timedue)) {
            $record->timedue = 0;
        }

        return parent::create_instance($record, (array)$options);
    }
}
