<?php

/**
 * Unit tests for subscription manager api.
 *
 * @package    tool
 * @subpackage monitor
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;

/**
 * Tests for subscription manager.
 *
 * Class tool_monitor_subscription_manager_testcase.
 */
class tool_monitor_subscription_manager_testcase extends advanced_testcase {

    /**
     * Test count_rule_subscriptions method.
     */
    public function test_count_rule_subscriptions() {

        $this->setAdminUser();
        $this->resetAfterTest(true);

        // Create users.
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        // Create few rules.
        $monitorgenerator = $this->getDataGenerator()->get_plugin_generator('tool_monitor');
        $rule1 = $monitorgenerator->create_rule();
        $rule2 = $monitorgenerator->create_rule();
        $subs = \tool_monitor\subscription_manager::count_rule_subscriptions($rule1->id);

        // No subscriptions at this point.
        $this->assertEquals(0, $subs);

        // Subscribe user 1 to rule 1.
        $record = new stdClass;
        $record->ruleid = $rule1->id;
        $record->userid = $user1->id;
        $monitorgenerator->create_subscription($record);

        // Subscribe user 2 to rule 1.
        $record->userid = $user2->id;
        $monitorgenerator->create_subscription($record);

        // Subscribe user 2 to rule 2.
        $record->ruleid = $rule2->id;
        $monitorgenerator->create_subscription($record);

        // Should have 2 subscriptions for rule 1 and 1 subscription for rule 2
        $subs1 = \tool_monitor\subscription_manager::count_rule_subscriptions($rule1->id);
        $subs2 = \tool_monitor\subscription_manager::count_rule_subscriptions($rule2->id);
        $this->assertEquals(2, $subs1);
        $this->assertEquals(1, $subs2);
    }
}