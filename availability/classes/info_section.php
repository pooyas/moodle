<?php


/**
 * Class handles conditional availability information for a section.
 *
 * @package    availability
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
 */

namespace core_availability;

defined('LION_INTERNAL') || die();

/**
 * Class handles conditional availability information for a section.
 *
 */
class info_section extends info {
    /** @var \section_info Section. */
    protected $section;

    /**
     * Constructs with item details.
     *
     * @param \section_info $section Section object
     */
    public function __construct(\section_info $section) {
        parent::__construct($section->modinfo->get_course(), $section->visible,
                $section->availability);
        $this->section = $section;
    }

    protected function get_thing_name() {
        return get_section_name($this->section->course, $this->section->section);
    }

    public function get_context() {
        return \context_course::instance($this->get_course()->id);
    }

    protected function get_view_hidden_capability() {
        return 'lion/course:viewhiddensections';
    }

    protected function set_in_database($availability) {
        global $DB;
        $DB->set_field('course_sections', 'availability', $availability,
                array('id' => $this->section->id));
    }

    /**
     * Gets the section object. Intended for use by conditions.
     *
     * @return \section_info Section
     */
    public function get_section() {
        return $this->section;
    }

}
