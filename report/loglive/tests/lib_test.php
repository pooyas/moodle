<?php

/**
 * Tests for report library functions.
 *
 * @package    report_loglive
 * @copyright  2014 onwards Ankit agarwal <ankit.agrr@gmail.com>
 * .
 */

defined('LION_INTERNAL') || die();

/**
 * Class report_loglive_lib_testcase
 *
 * @package    report_loglive
 * @copyright  2014 onwards Ankit agarwal <ankit.agrr@gmail.com>
 * .
 */
class report_loglive_lib_testcase extends advanced_testcase {

    /**
     * Test report_log_supports_logstore.
     */
    public function test_report_participation_supports_logstore() {
        $logmanager = get_log_manager();
        $allstores = \core_component::get_plugin_list_with_class('logstore', 'log\store');

        $supportedstores = array(
            'logstore_database' => '\logstore_legacy\log\database',
            'logstore_legacy' => '\logstore_legacy\log\store',
            'logstore_standard' => '\logstore_standard\log\store'
        );

        // Make sure all supported stores are installed.
        $expectedstores = array_keys(array_intersect($allstores, $supportedstores));
        $stores = $logmanager->get_supported_logstores('report_loglive');
        $stores = array_keys($stores);
        foreach ($expectedstores as $expectedstore) {
            $this->assertContains($expectedstore, $stores);
        }
    }
}
