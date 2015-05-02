<?php

/**
 * File system repository data generator
 *
 * @package    repository_filesystem
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
 */

/**
 * File system repository data generator class
 *
 * @package    repository_filesystem
 * @category   test
 * @copyright  2013 Frédéric Massart
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
