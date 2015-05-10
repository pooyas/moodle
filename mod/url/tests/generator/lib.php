<?php

/**
 * mod_url data generator.
 *
 * @package    mod
 * @subpackage survey
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * mod_url data generator class.
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
