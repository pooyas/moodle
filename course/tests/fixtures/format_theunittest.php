<?php

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/course/format/lib.php');

/**
 * Fixture for fake course format testing course format API.
 *
 * @package    core
 * @subpackage course
 * @copyright  2015 Pooya Saeedi
 * 
 */
class format_theunittest extends format_base {

    /**
     * Definitions of the additional options that format uses
     *
     * @param bool $foreditform
     * @return array of options
     */
    public function course_format_options($foreditform = false) {
        static $courseformatoptions = false;
        if ($courseformatoptions === false) {
            $courseformatoptions = array(
                'hideoddsections' => array(
                    'default' => 0,
                    'type' => PARAM_INT,
                ),
            );
        }
        if ($foreditform && !isset($courseformatoptions['hideoddsections']['label'])) {
            $sectionmenu = array(
                0 => 'Never',
                1 => 'Hide without notice',
                2 => 'Hide with notice'
            );
            $courseformatoptionsedit = array(
                'hideoddsections' => array(
                    'label' => 'Hide odd sections',
                    'element_type' => 'select',
                    'element_attributes' => array($sectionmenu),
                ),
            );
            $courseformatoptions = array_merge_recursive($courseformatoptions, $courseformatoptionsedit);
        }
        return $courseformatoptions;
    }

    /**
     * Allows to specify for modinfo that section is not available even when it is visible and conditionally available.
     *
     * @param section_info $section
     * @param bool $available
     * @param string $availableinfo
     */
    public function section_get_available_hook(section_info $section, &$available, &$availableinfo) {
        if (($section->section % 2) && ($hideoddsections = $this->get_course()->hideoddsections)) {
            $available = false;
            if ($hideoddsections == 2) {
                $availableinfo = 'Odd sections are oddly hidden';
            } else {
                $availableinfo = '';
            }
        }
    }
}