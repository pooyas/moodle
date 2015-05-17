<?php


/**
 * WebDAV repository data generator
 *
 * @category   test
 * @package    repository
 * @subpackage webdav
 * @copyright  2015 Pooya Saeedi
 */

/**
 * WebDAV repository data generator class
 *
 * @category   test
 */
class repository_webdav_generator extends testing_repository_generator {

    /**
     * Fill in record defaults.
     *
     * @param array $record
     * @return array
     */
    protected function prepare_record(array $record) {
        $record = parent::prepare_record($record);
        if (!isset($record['webdav_type'])) {
            $record['webdav_type'] = 0;
        }
        if (!isset($record['webdav_server'])) {
            $record['webdav_server'] = 'webdav.server.local';
        }
        if (!isset($record['webdav_port'])) {
            $record['webdav_port'] = '';
        }
        if (!isset($record['webdav_path'])) {
            $record['webdav_path'] = '/';
        }
        if (!isset($record['webdav_user'])) {
            $record['webdav_user'] = '';
        }
        if (!isset($record['webdav_password'])) {
            $record['webdav_password'] = '';
        }
        if (!isset($record['webdav_auth'])) {
            $record['webdav_auth'] = 'none';
        }
        return $record;
    }


}
