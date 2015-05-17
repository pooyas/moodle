<?php


/**
 * Contains class restore_gradingform_plugin responsible for advanced grading form plugin backup
 *
 * @package    backup
 * @subpackage lion2
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Base class for restoring all advanced grading form plugins
 *
 * As an example of implementation see {@link restore_gradingform_rubric_plugin}
 *
 * @category   backup
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
