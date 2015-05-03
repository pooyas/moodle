<?php


/**
 * Utility class for browsing of system files.
 *
 * @package    core_files
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Represents the system context in the tree navigated by {@link file_browser}.
 *
 * @package    core_files
 * @copyright  2015 Pooya Saeedi 
 * 
 */
class file_info_context_system extends file_info {

    /**
     * Constructor
     *
     * @param file_browser $browser file_browser instance
     * @param stdClass $context context object
     */
    public function __construct($browser, $context) {
        parent::__construct($browser, $context);
    }

    /**
     * Return information about this specific part of context level
     *
     * @param string $component component
     * @param string $filearea file area
     * @param int $itemid item ID
     * @param string $filepath file path
     * @param string $filename file name
     */
    public function get_file_info($component, $filearea, $itemid, $filepath, $filename) {
        if (empty($component)) {
            return $this;
        }

        // no components supported at this level yet
        return null;
    }

    /**
     * Returns localised visible name.
     *
     * @return string
     */
    public function get_visible_name() {
        return get_string('arearoot', 'repository');
    }

    /**
     * Whether or not new files or directories can be added
     *
     * @return bool
     */
    public function is_writable() {
        return false;
    }

    /**
     * Whether or not this is a directory
     *
     * @return bool
     */
    public function is_directory() {
        return true;
    }

    /**
     * Returns list of children.
     *
     * @return array of file_info instances
     */
    public function get_children() {
        global $DB, $USER;

        $children = array();

        $course_cats = $DB->get_records('course_categories', array('parent'=>0), 'sortorder', 'id,visible');
        foreach ($course_cats as $category) {
            $context = context_coursecat::instance($category->id);
            if (!$category->visible and !has_capability('lion/category:viewhiddencategories', $context)) {
                continue;
            }
            if ($child = $this->browser->get_file_info($context)) {
                $children[] = $child;
            }
        }

        $courses = $DB->get_records('course', array('category'=>0), 'sortorder', 'id,visible');
        foreach ($courses as $course) {
            if (!$course->visible and !has_capability('lion/course:viewhiddencourses', $context)) {
                continue;
            }
            $context = context_course::instance($course->id);
            if ($child = $this->browser->get_file_info($context)) {
                $children[] = $child;
            }
        }

        return $children;
    }

    /**
     * Returns parent file_info instance
     *
     * @return file_info|null file_info instance or null for root
     */
    public function get_parent() {
        return null;
    }
}
