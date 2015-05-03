<?php

/**
 * Flickr Public repository data generator
 *
 * @package    repository_flickr_public
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Flickr Public repository data generator class
 *
 * @package    repository_flickr_public
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class repository_flickr_public_generator extends testing_repository_generator {

    /**
     * Fill in record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_record(array $record) {
        $record = parent::prepare_record($record);
        if (!isset($record['email_address'])) {
            $record['email_address'] = '';
        }
        if (!isset($record['usewatermarks'])) {
            $record['usewatermarks'] = 0;
        }
        return $record;
    }

    /**
     * Fill in type record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_type_record(array $record) {
        $record = parent::prepare_type_record($record);
        if (!isset($record['api_key'])) {
            $record['api_key'] = 'api_key';
        }
        return $record;
    }

}
