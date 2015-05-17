<?php


/**
 * Alfresco repository data generator
 *
 * @category   test
 * @package    repository
 * @subpackage alfresco
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Alfresco repository data generator class
 *
 * @category   test
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
