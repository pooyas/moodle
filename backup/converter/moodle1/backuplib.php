<?php
/**
 * @package   core
 * @subpackage backup
 * @copyright 2015 Pooya Saeedi
 */

require_once($CFG->dirroot . '/backup/converter/convertlib.php');

class moodle1_export_converter extends base_converter {
    public static function is_available() {
        return false;
    }

    protected function execute() {

    }
}