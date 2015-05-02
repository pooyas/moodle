<?php

/**
 * mod_url data generator.
 *
 * @package    mod_url
 * @category   test
 * @copyright  2013 Marina Glancy
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * mod_url data generator class.
 *
 * @package    mod_url
 * @category   test
 * @copyright  2013 Marina Glancy
 * 
 */
class mod_url_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        global $CFG;
        require_once($CFG->libdir.'/resourcelib.php');

        // Add default values for url.
        $record = (array)$record + array(
            'display' => RESOURCELIB_DISPLAY_AUTO,
            'externalurl' => 'http://lion.org/',
        );

        return parent::create_instance($record, (array)$options);
    }
}
