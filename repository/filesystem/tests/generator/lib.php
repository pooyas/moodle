<?php

/**
 * File system repository data generator
 *
 * @package    repository
 * @subpackage filesystem
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * File system repository data generator class
 *
 */
class repository_filesystem_generator extends testing_repository_generator {

    /**
     * Fill in record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_record(array $record) {
        $record = parent::prepare_record($record);
        if (!isset($record['fs_path'])) {
            $record['fs_path'] = '/i/do/not/exist';
        }
        if (!isset($record['relativefiles'])) {
            $record['relativefiles'] = 0;
        }
        return $record;
    }

}
