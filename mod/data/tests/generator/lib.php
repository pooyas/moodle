<?php


/**
 * mod_data data generator
 *
 * @category   test
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();


/**
 * Database module data generator class
 *
 * @category   test
 */
class mod_data_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        $record = (object)(array)$record;

        if (!isset($record->assessed)) {
            $record->assessed = 0;
        }
        if (!isset($record->scale)) {
            $record->scale = 0;
        }

        return parent::create_instance($record, (array)$options);
    }
}
