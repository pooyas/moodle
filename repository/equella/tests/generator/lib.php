<?php

/**
 * Equella repository data generator
 *
 * @package    repository_equella
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
 */

/**
 * Equella repository data generator class
 *
 * @package    repository_equella
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
 */
class repository_equella_generator extends testing_repository_generator {

    /**
     * Fill in record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_record(array $record) {
        $record = parent::prepare_record($record);
        if (!isset($record['equella_url'])) {
            $record['equella_url'] = 'http://dummy.url.com';
        }
        if (!isset($record['equella_select_restriction'])) {
            $record['equella_select_restriction'] = 'none';
        }
        if (!isset($record['equella_options'])) {
            $record['equella_options'] = '';
        }
        if (!isset($record['equella_shareid'])) {
            $record['equella_shareid'] = 'id';
        }
        if (!isset($record['equella_sharesecret'])) {
            $record['equella_url'] = 'secret';
        }
        return $record;
    }

}
