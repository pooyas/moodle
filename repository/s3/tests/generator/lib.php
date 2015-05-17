<?php


/**
 * Amazon S3 repository data generator
 *
 * @category   test
 * @package    repository
 * @subpackage s3
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Amazon S3 repository data generator class
 *
 * @category   test
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
