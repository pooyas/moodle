<?php

/**
 * mod_lti data generator
 *
 * @package    mod_lti
 * @category   test
 * @copyright  Copyright (c) 2012 Lionrooms Inc. (http://www.lionrooms.com)
 * @author     Mark Nielsen
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * LTI module data generator class
 *
 * @package    mod_lti
 * @category   test
 * @copyright  Copyright (c) 2012 Lionrooms Inc. (http://www.lionrooms.com)
 * @author     Mark Nielsen
 * 
 */
class mod_lti_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        $record  = (object) (array) $record;

        if (!isset($record->toolurl)) {
            $record->toolurl = 'http://www.imsglobal.org/developers/LTI/test/v1p1/tool.php';
        }
        if (!isset($record->resourcekey)) {
            $record->resourcekey = '12345';
        }
        if (!isset($record->password)) {
            $record->password = 'secret';
        }
        if (!isset($record->grade)) {
            $record->grade = 100;
        }
        if (!isset($record->instructorchoicesendname)) {
            $record->instructorchoicesendname = 1;
        }
        if (!isset($record->instructorchoicesendemailaddr)) {
            $record->instructorchoicesendemailaddr = 1;
        }
        if (!isset($record->instructorchoiceacceptgrades)) {
            $record->instructorchoiceacceptgrades = 1;
        }
        return parent::create_instance($record, (array)$options);
    }
}
