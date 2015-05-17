<?php


/**
 * Picasa repository data generator
 *
 * @category   test
 * @package    repository
 * @subpackage picasa
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Picasa repository data generator class
 *
 * @category   test
 */
class repository_picasa_generator extends testing_repository_generator {

    /**
     * Fill in type record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_type_record(array $record) {
        $record = parent::prepare_type_record($record);
        if (!isset($record['clientid'])) {
            $record['clientid'] = 'clientid';
        }
        if (!isset($record['secret'])) {
            $record['secret'] = 'secret';
        }
        return $record;
    }

}
