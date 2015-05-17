<?php


/**
 * External airnotifier functions unit tests
 *
 * @category   external
 * @package    message
 * @subpackage output
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');

/**
 * External airnotifier functions unit tests
 *
 * @category   external
 */
class message_airnotifier_external_testcase extends externallib_advanced_testcase {

    /**
     * Tests set up
     */
    protected function setUp() {
        global $CFG;
        require_once($CFG->dirroot . '/message/output/airnotifier/externallib.php');
    }

    /**
     * Test is_system_configured
     */
    public function test_is_system_configured() {
        global $DB;

        $this->resetAfterTest(true);

        $user  = self::getDataGenerator()->create_user();
        self::setUser($user);

        // In a clean installation, it should be not configured.
        $configured = message_airnotifier_external::is_system_configured();
        $this->assertEquals(0, $configured);

        // Fake configuration.
        set_config('airnotifieraccesskey', random_string());
        // Enable the plugin.
        $DB->set_field('message_processors', 'enabled', 1, array('name' => 'airnotifier'));

        $configured = message_airnotifier_external::is_system_configured();
        $this->assertEquals(1, $configured);
    }

    /**
     * Test are_notification_preferences_configured
     */
    public function test_are_notification_preferences_configured() {

        $this->resetAfterTest(true);

        $user1  = self::getDataGenerator()->create_user();
        $user2  = self::getDataGenerator()->create_user();
        $user3  = self::getDataGenerator()->create_user();

        self::setUser($user1);

        set_user_preference('message_provider_lion_instantmessage_loggedin', 'airnotifier', $user1);
        set_user_preference('message_provider_lion_instantmessage_loggedoff', 'airnotifier', $user1);
        set_user_preference('message_provider_lion_instantmessage_loggedin', 'airnotifier', $user2);
        set_user_preference('message_provider_lion_instantmessage_loggedin', 'airnotifier', $user3);

        $params = array($user1->id, $user2->id, $user3->id);

        $preferences = message_airnotifier_external::are_notification_preferences_configured($params);

        $expected = array(
            array(
                'userid' => $user1->id,
                'configured' => 1
            )
        );

        $this->assertEquals(1, count($preferences['users']));
        $this->assertEquals($expected, $preferences['users']);
        $this->assertEquals(2, count($preferences['warnings']));

        // Now, remove one user.
        delete_user($user2);
        $preferences = message_airnotifier_external::are_notification_preferences_configured($params);
        $this->assertEquals(1, count($preferences['users']));
        $this->assertEquals($expected, $preferences['users']);
        $this->assertEquals(2, count($preferences['warnings']));

        // Now, remove one user1 preference (the user still has one prefernce for airnotifier).
        unset_user_preference('message_provider_lion_instantmessage_loggedin', $user1);
        $preferences = message_airnotifier_external::are_notification_preferences_configured($params);
        $this->assertEquals($expected, $preferences['users']);

        // Delete the last user1 preference.
        unset_user_preference('message_provider_lion_instantmessage_loggedoff', $user1);
        $preferences = message_airnotifier_external::are_notification_preferences_configured($params);
        $expected = array(
            array(
                'userid' => $user1->id,
                'configured' => 0
            )
        );
        $this->assertEquals($expected, $preferences['users']);
    }

}
