<?php

/**
 * Code quality unit tests that are fast enough to run each time.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

class core_ajaxlib_testcase extends advanced_testcase {
    /** @var string Original error log */
    protected $oldlog;

    protected function setUp() {
        global $CFG;

        parent::setUp();
        // Discard error logs.
        $this->oldlog = ini_get('error_log');
        ini_set('error_log', "$CFG->dataroot/testlog.log");
    }

    protected function tearDown() {
        ini_set('error_log', $this->oldlog);
        parent::tearDown();
    }

    protected function helper_test_clean_output() {
        $this->resetAfterTest();

        $result = ajax_capture_output();

        // ob_start should normally return without issue.
        $this->assertTrue($result);

        $result = ajax_check_captured_output();
        $this->assertEmpty($result);
    }

    protected function helper_test_dirty_output($expectexception = false) {
        $this->resetAfterTest();

        // Keep track of the content we will output.
        $content = "Some example content";

        $result = ajax_capture_output();

        // ob_start should normally return without issue.
        $this->assertTrue($result);

        // Fill the output buffer.
        echo $content;

        if ($expectexception) {
            $this->setExpectedException('coding_exception');
            ajax_check_captured_output();
        } else {
            $result = ajax_check_captured_output();
            $this->assertEquals($result, $content);
        }
    }

    public function test_output_capture_normal_debug_none() {
        // In normal conditions, and with DEBUG_NONE set, we should not receive any output or throw any exceptions.
        set_debugging(DEBUG_NONE);
        $this->helper_test_clean_output();
    }

    public function test_output_capture_normal_debug_normal() {
        // In normal conditions, and with DEBUG_NORMAL set, we should not receive any output or throw any exceptions.
        set_debugging(DEBUG_NORMAL);
        $this->helper_test_clean_output();
    }

    public function test_output_capture_normal_debug_all() {
        // In normal conditions, and with DEBUG_ALL set, we should not receive any output or throw any exceptions.
        set_debugging(DEBUG_ALL);
        $this->helper_test_clean_output();
    }

    public function test_output_capture_normal_debugdeveloper() {
        // In normal conditions, and with DEBUG_DEVELOPER set, we should not receive any output or throw any exceptions.
        set_debugging(DEBUG_DEVELOPER);
        $this->helper_test_clean_output();
    }

    public function test_output_capture_error_debug_none() {
        // With DEBUG_NONE set, we should not throw any exception, but the output will be returned.
        set_debugging(DEBUG_NONE);
        $this->helper_test_dirty_output();
    }

    public function test_output_capture_error_debug_normal() {
        // With DEBUG_NORMAL set, we should not throw any exception, but the output will be returned.
        set_debugging(DEBUG_NORMAL);
        $this->helper_test_dirty_output();
    }

    public function test_output_capture_error_debug_all() {
        // In error conditions, and with DEBUG_ALL set, we should not receive any output or throw any exceptions.
        set_debugging(DEBUG_ALL);
        $this->helper_test_dirty_output();
    }

    public function test_output_capture_error_debugdeveloper() {
        // With DEBUG_DEVELOPER set, we should throw an exception.
        set_debugging(DEBUG_DEVELOPER);
        $this->helper_test_dirty_output(true);
    }

}
