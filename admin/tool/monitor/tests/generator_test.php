<?php


/**
 * PHPUnit data generator tests.
 *
 * @category   test
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * PHPUnit data generator test case.
 *
 * @category   test
 */
class tool_monitor_generator_testcase extends advanced_testcase {

    /**
     * Set up method.
     */
    public function setUp() {
        // Enable monitor.
        set_config('enablemonitor', 1, 'tool_monitor');
    }

    /**
     * Test create_rule data generator.
     */
    public function test_create_rule() {
        $this->setAdminUser();
        $this->resetAfterTest(true);
        $course = $this->getDataGenerator()->create_course();
        $user = $this->getDataGenerator()->create_user();

        $rulegenerator = $this->getDataGenerator()->get_plugin_generator('tool_monitor');

        $record = new stdClass();
        $record->courseid = $course->id;
        $record->userid = $user->id;

        $rule = $rulegenerator->create_rule($record);
        $this->assertInstanceOf('tool_monitor\rule', $rule);
        $this->assertEquals($rule->userid, $record->userid);
        $this->assertEquals($rule->courseid, $record->courseid);
    }

    /**
     * Test create_subscription data generator.
     */
    public function test_create_subscription() {
        $this->setAdminUser();
        $this->resetAfterTest(true);

        $user = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();
        $monitorgenerator = $this->getDataGenerator()->get_plugin_generator('tool_monitor');
        $rule = $monitorgenerator->create_rule();

        $record = new stdClass();
        $record->courseid = $course->id;
        $record->userid = $user->id;
        $record->ruleid = $rule->id;

        $subscription = $monitorgenerator->create_subscription($record);
        $this->assertEquals($record->courseid, $subscription->courseid);
        $this->assertEquals($record->ruleid, $subscription->ruleid);
        $this->assertEquals($record->userid, $subscription->userid);
        $this->assertEquals(0, $subscription->cmid);

        // Make sure rule id is always required.
        $this->setExpectedException('coding_exception');
        unset($record->ruleid);
        $monitorgenerator->create_subscription($record);
    }

    /**
     * Test create_event data generator.
     */
    public function test_create_event_entries() {
        $this->setAdminUser();
        $this->resetAfterTest(true);
        $context = \context_system::instance();

        // Default data generator values.
        $monitorgenerator = $this->getDataGenerator()->get_plugin_generator('tool_monitor');

        // First create and assertdata using default values.
        $eventdata = $monitorgenerator->create_event_entries();
        $this->assertEquals('\core\event\user_loggedin', $eventdata->eventname);
        $this->assertEquals($context->id, $eventdata->contextid);
        $this->assertEquals($context->contextlevel, $eventdata->contextlevel);
    }

    /**
     * Test create_history data generator.
     */
    public function test_create_history() {
        $this->setAdminUser();
        $this->resetAfterTest(true);
        $user = $this->getDataGenerator()->create_user();
        $monitorgenerator = $this->getDataGenerator()->get_plugin_generator('tool_monitor');
        $rule = $monitorgenerator->create_rule();

        $record = new \stdClass();
        $record->userid = $user->id;
        $record->ruleid = $rule->id;
        $sid = $monitorgenerator->create_subscription($record)->id;
        $record->sid = $sid;
        $historydata = $monitorgenerator->create_history($record);
        $this->assertEquals($record->userid, $historydata->userid);
        $this->assertEquals($record->sid, $historydata->sid);

        // Test using default values.
        $record->userid = 1;
        $record->sid = 1;
        $historydata = $monitorgenerator->create_history($record);
        $this->assertEquals(1, $historydata->userid);
        $this->assertEquals(1, $historydata->sid);
    }
}