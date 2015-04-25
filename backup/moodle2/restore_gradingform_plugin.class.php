<?php

/**
 * Contains class restore_gradingform_plugin responsible for advanced grading form plugin backup
 *
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Base class for restoring all advanced grading form plugins
 */
abstract class restore_gradingform_plugin extends restore_plugin {

    /**
     * Helper method returning the mapping identifierto use for
     * grading form instance's itemid field
     *
     * @param array $areaname the name of the area the form is defined for
     * @return string the mapping identifier
     */
    public static function itemid_mapping($areaname) {
        return 'grading_item_'.$areaname;
    }
}
