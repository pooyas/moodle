<?php


/**
 * Box.net repository data generator
 *
 * @category   test
 * @package    repository
 * @subpackage boxnet
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Box.net repository data generator class
 *
 * @category   test
 */
class repository_boxnet_generator extends testing_repository_generator {

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
        if (!isset($record['clientsecret'])) {
            $record['clientsecret'] = 'clientsecret';
        }
        return $record;
    }

}
