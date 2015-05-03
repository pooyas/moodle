<?php

/**
 * Tests for report library functions.
 *
 * @package    report_log
 * @copyright  2015 Pooya Saeedi 
 * .
 */

defined('LION_INTERNAL') || die();

/**
 * Class report_log_events_testcase.
 *
 * @package    report_log
 * @copyright  2015 Pooya Saeedi 
 * .
 */
class report_log_lib_testcase extends advanced_testcase {

    /**
     * Test report_log_supports_logstore.
     */
    public function test_report_log_supports_logstore() {
        $logmanager = get_log_manager();
        $allstores = \core_component::get_plugin_list_with_class('logstore', 'log\store');

        $supportedstores = array(
            'logstore_database' => '\logstore_database\log\store',
            'logstore_legacy' => '\logstore_legacy\log\store',
            'logstore_standard' => '\logstore_standard\log\store'
        );

        // Make sure all supported stores are installed.
        $expectedstores = array_keys(array_intersect($allstores, $supportedstores));
        $stores = $logmanager->get_supported_logstores('report_log');
        $stores = array_keys($stores);
        foreach ($expectedstores as $expectedstore) {
            $this->assertContains($expectedstore, $stores);
        }
    }
}
