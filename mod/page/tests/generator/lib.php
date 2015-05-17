<?php


/**
 * mod_page data generator
 *
 * @category   test
 * @package    mod
 * @subpackage page
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();


/**
 * Page module data generator class
 *
 * @category   test
 */
class mod_page_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        global $CFG;
        require_once($CFG->dirroot . '/lib/resourcelib.php');

        $record = (object)(array)$record;

        if (!isset($record->content)) {
            $record->content = 'Test page content';
        }
        if (!isset($record->contentformat)) {
            $record->contentformat = FORMAT_LION;
        }
        if (!isset($record->display)) {
            $record->display = RESOURCELIB_DISPLAY_AUTO;
        }
        if (!isset($record->printheading)) {
            $record->printheading = 1;
        }
        if (!isset($record->printintro)) {
            $record->printintro = 0;
        }

        return parent::create_instance($record, (array)$options);
    }
}
