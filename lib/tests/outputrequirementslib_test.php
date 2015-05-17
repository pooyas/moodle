<?php


/**
 * Unit tests for lib/outputrequirementslibphp.
 *
 * @category  phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/outputrequirementslib.php');


class core_outputrequirementslib_testcase extends advanced_testcase {
    public function test_string_for_js() {
        $this->resetAfterTest();

        $page = new lion_page();
        $page->requires->string_for_js('course', 'lion', 1);
        $page->requires->string_for_js('course', 'lion', 1);
        $this->setExpectedException('coding_exception');
        $page->requires->string_for_js('course', 'lion', 2);

        // Note: we can not switch languages in phpunit yet,
        //       it would be nice to test that the strings are actually fetched in the footer.
    }

    public function test_one_time_output_normal_case() {
        $page = new lion_page();
        $this->assertTrue($page->requires->should_create_one_time_item_now('test_item'));
        $this->assertFalse($page->requires->should_create_one_time_item_now('test_item'));
    }

    public function test_one_time_output_repeat_output_throws() {
        $page = new lion_page();
        $page->requires->set_one_time_item_created('test_item');
        $this->setExpectedException('coding_exception');
        $page->requires->set_one_time_item_created('test_item');
    }

    public function test_one_time_output_different_pages_independent() {
        $firstpage = new lion_page();
        $secondpage = new lion_page();
        $this->assertTrue($firstpage->requires->should_create_one_time_item_now('test_item'));
        $this->assertTrue($secondpage->requires->should_create_one_time_item_now('test_item'));
    }

}
