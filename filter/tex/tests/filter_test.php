<?php


/**
 * Unit test for the filter_tex
 *
 * @package    filter
 * @subpackage tex
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/tex/filter.php');


/**
 * Unit tests for filter_tex.
 *
 * Test the delimiter parsing used by the tex filter.
 *
 */
class filter_tex_testcase extends advanced_testcase {

    protected $filter;

    protected function setUp() {
        parent::setUp();
        $this->resetAfterTest(true);
        $this->filter = new filter_tex(context_system::instance(), array());
    }

    function run_with_delimiters($start, $end, $filtershouldrun) {
        $pre = 'Some pre text';
        $post = 'Some post text';
        $equation = ' \sum{a^b} ';

        $before = $pre . $start . $equation . $end . $post;

        $after = trim($this->filter->filter($before));

        if ($filtershouldrun) {
            $this->assertNotEquals($after, $before);
        } else {
            $this->assertEquals($after, $before);
        }
    }

    function test_delimiters() {
        // First test the list of supported delimiters.
        $this->run_with_delimiters('$$', '$$', true);
        $this->run_with_delimiters('\\(', '\\)', true);
        $this->run_with_delimiters('\\[', '\\]', true);
        $this->run_with_delimiters('[tex]', '[/tex]', true);
        $this->run_with_delimiters('<tex>', '</tex>', true);
        $this->run_with_delimiters('<tex alt="nonsense">', '</tex>', true);
        // Now test some cases that shouldn't be executed.
        $this->run_with_delimiters('<textarea>', '</textarea>', false);
        $this->run_with_delimiters('$', '$', false);
        $this->run_with_delimiters('(', ')', false);
        $this->run_with_delimiters('[', ']', false);
        $this->run_with_delimiters('$$', '\\]', false);
    }

}
