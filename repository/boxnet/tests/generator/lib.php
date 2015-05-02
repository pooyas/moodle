<?php

/**
 * Box.net repository data generator
 *
 * @package    repository_boxnet
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
 */

/**
 * Box.net repository data generator class
 *
 * @package    repository_boxnet
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
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
