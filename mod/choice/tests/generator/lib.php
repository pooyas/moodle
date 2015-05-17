<?php


/**
 * mod_choice data generator.
 *
 * @category test
 * @package    mod
 * @subpackage choice
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * mod_choice data generator class.
 *
 * @category test
 */
class mod_choice_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        $record = (object)(array)$record;

        if (!isset($record->timemodified)) {
            $record->timemodified = time();
        }
        if (!isset($record->option)) {
            $record->option = array();
            $record->option[] = 'Soft Drink';
            $record->option[] = 'Beer';
            $record->option[] = 'Wine';
            $record->option[] = 'Spirits';
        }
        return parent::create_instance($record, (array)$options);
    }
}
