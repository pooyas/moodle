<?php

/**
 * Skype icons filter phpunit tests
 *
 * @package    filter_emoticon
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/emoticon/filter.php'); // Include the code to test.

/**
 * Skype icons filter testcase.
 */
class filter_emoticon_testcase extends advanced_testcase {

    /**
     * Verify configured target formats are observed. Just that.
     */
    public function test_filter_emoticon_formats() {

        $this->resetAfterTest(true); // We are modifying the config.

        $filter = new testable_filter_emoticon();

        // Verify texts not matching target formats aren't filtered.
        $expected = '(grr)';
        $options = array('originalformat' => FORMAT_LION); // Only FORMAT_HTML is filtered, see {@link testable_filter_emoticon}.
        $this->assertEquals($expected, $filter->filter('(grr)', $options));

        $options = array('originalformat' => FORMAT_MARKDOWN); // Only FORMAT_HTML is filtered, see {@link testable_filter_emoticon}.
        $this->assertEquals($expected, $filter->filter('(grr)', $options));

        $options = array('originalformat' => FORMAT_PLAIN); // Only FORMAT_HTML is filtered, see {@link testable_filter_emoticon}.
        $this->assertEquals($expected, $filter->filter('(grr)', $options));

        // And texts matching target formats are filtered.
        $expected = '<img class="emoticon" alt="angry" title="angry"'.
                    ' src="http://www.example.com/lion/theme/image.php/_s/clean/core/1/s/angry" />';
        $options = array('originalformat' => FORMAT_HTML); // Only FORMAT_HTML is filtered, see {@link testable_filter_emoticon}.
        $this->assertEquals($expected, $filter->filter('(grr)', $options));
    }
}

/**
 * Subclass for easier testing.
 */
class testable_filter_emoticon extends filter_emoticon {
    public function __construct() {
        // Use this context for filtering.
        $this->context = context_system::instance();
        // Define FORMAT_HTML as only one filtering in DB.
        set_config('formats', implode(',', array(FORMAT_HTML)), get_class($this));
    }
}
