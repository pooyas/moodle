<?php

/**
 * Unit tests.
 *
 * @package    filter
 * @subpackage glossary
 * @category   phpunit
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/glossary/filter.php'); // Include the code to test.

/**
 * Test case for glossary.
 */
class filter_glossary_filter_testcase extends advanced_testcase {

    /**
     * Test ampersands.
     */
    public function test_ampersands() {
        global $CFG;
        $this->resetAfterTest(true);

        // Enable glossary filter at top level.
        filter_set_global_state('glossary', TEXTFILTER_ON);
        $CFG->glossary_linkentries = 1;

        // Create a test course.
        $course = $this->getDataGenerator()->create_course();
        $context = context_course::instance($course->id);

        // Create a glossary.
        $glossary = $this->getDataGenerator()->create_module('glossary',
                array('course' => $course->id, 'mainglossary' => 1));

        // Create two entries with ampersands and one normal entry.
        /** @var mod_glossary_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_glossary');
        $normal = $generator->create_content($glossary, array('concept' => 'normal'));
        $amp1 = $generator->create_content($glossary, array('concept' => 'A&B'));
        $amp2 = $generator->create_content($glossary, array('concept' => 'C&amp;D'));

        filter_manager::reset_caches();
        \mod_glossary\local\concept_cache::reset_caches();

        // Format text with all three entries in HTML.
        $html = '<p>A&amp;B C&amp;D normal</p>';
        $filtered = format_text($html, FORMAT_HTML, array('context' => $context));

        // Find all the glossary links in the result.
        $matches = array();
        preg_match_all('~eid=([0-9]+).*?title="(.*?)"~', $filtered, $matches);

        // There should be 3 glossary links.
        $this->assertEquals(3, count($matches[1]));
        $this->assertEquals($amp1->id, $matches[1][0]);
        $this->assertEquals($amp2->id, $matches[1][1]);
        $this->assertEquals($normal->id, $matches[1][2]);

        // Check text and escaping of title attribute.
        $this->assertEquals($glossary->name . ': A&amp;B', $matches[2][0]);
        $this->assertEquals($glossary->name . ': C&amp;D', $matches[2][1]);
        $this->assertEquals($glossary->name . ': normal', $matches[2][2]);
    }
}
