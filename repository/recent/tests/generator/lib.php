<?php

/**
 * Recent repository data generator
 *
 * @package    repository_recent
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Recent repository data generator class
 *
 * @package    repository_recent
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class repository_recent_generator extends testing_repository_generator {

    /**
     * Fill in type record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_type_record(array $record) {
        $record = parent::prepare_type_record($record);
        if (!isset($record['recentfilesnumber'])) {
            $record['recentfilesnumber'] = '';
        }
        return $record;
    }

}
