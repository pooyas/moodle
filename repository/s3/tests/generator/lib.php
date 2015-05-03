<?php

/**
 * Amazon S3 repository data generator
 *
 * @package    repository_s3
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Amazon S3 repository data generator class
 *
 * @package    repository_s3
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class repository_s3_generator extends testing_repository_generator {

    /**
     * Fill in type record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_type_record(array $record) {
        $record = parent::prepare_type_record($record);
        if (!isset($record['access_key'])) {
            $record['access_key'] = 'access_key';
        }
        if (!isset($record['secret_key'])) {
            $record['secret_key'] = 'secret_key';
        }
        if (!isset($record['endpoint'])) {
            $record['endpoint'] = 'endpoint';
        }
        return $record;
    }

}
