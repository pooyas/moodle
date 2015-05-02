<?php

/**
 * Alfresco repository data generator
 *
 * @package    repository_alfresco
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
 */

/**
 * Alfresco repository data generator class
 *
 * @package    repository_alfresco
 * @category   test
 * @copyright  2013 Frédéric Massart
 * 
 */
class repository_alfresco_generator extends testing_repository_generator {

    /**
     * Fill in record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_record(array $record) {
        $record = parent::prepare_record($record);
        if (!isset($record['alfresco_url'])) {
            $record['alfresco_url'] = 'http://no.where.com/alfresco/api';
        }
        return $record;
    }

}
