<?php


/**
 * Unit tests for sessionlib.php file.
 *
 * @category  phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Unit tests for sessionlib.php file.
 *
 * @category  phpunit
 */
class core_sessionlib_testcase extends advanced_testcase {
    public function test_cron_setup_user() {
        global $PAGE, $USER, $SESSION, $SITE, $CFG;
        $this->resetAfterTest();

        // NOTE: this function contains some static caches, let's reset first.
        cron_setup_user('reset');

        $admin = get_admin();
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();

        cron_setup_user();
        $this->assertSame($admin->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($SITE->id));
        $this->assertSame($CFG->timezone, $USER->timezone);
        $this->assertSame('', $USER->lang);
        $this->assertSame('', $USER->theme);
        $SESSION->test1 = true;
        $adminsession = $SESSION;
        $adminuser = $USER;
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user(null, $course);
        $this->assertSame($admin->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($course->id));
        $this->assertSame($adminsession, $SESSION);
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user($user1);
        $this->assertSame($user1->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($SITE->id));
        $this->assertNotSame($adminsession, $SESSION);
        $this->assertObjectNotHasAttribute('test1', $SESSION);
        $this->assertEmpty((array)$SESSION);
        $usersession1 = $SESSION;
        $SESSION->test2 = true;
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user($user1);
        $this->assertSame($user1->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($SITE->id));
        $this->assertNotSame($adminsession, $SESSION);
        $this->assertSame($usersession1, $SESSION);
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user($user2);
        $this->assertSame($user2->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($SITE->id));
        $this->assertNotSame($adminsession, $SESSION);
        $this->assertNotSame($usersession1, $SESSION);
        $this->assertEmpty((array)$SESSION);
        $usersession2 = $SESSION;
        $usersession2->test3 = true;
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user($user2, $course);
        $this->assertSame($user2->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($course->id));
        $this->assertNotSame($adminsession, $SESSION);
        $this->assertNotSame($usersession1, $SESSION);
        $this->assertSame($usersession2, $SESSION);
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user($user1);
        $this->assertSame($user1->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($SITE->id));
        $this->assertNotSame($adminsession, $SESSION);
        $this->assertNotSame($usersession1, $SESSION);
        $this->assertEmpty((array)$SESSION);
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user();
        $this->assertSame($admin->id, $USER->id);
        $this->assertSame($PAGE->context, context_course::instance($SITE->id));
        $this->assertSame($adminsession, $SESSION);
        $this->assertSame($adminuser, $USER);
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user('reset');
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        cron_setup_user();
        $this->assertNotSame($adminsession, $SESSION);
        $this->assertNotSame($adminuser, $USER);
        $this->assertSame($GLOBALS['SESSION'], $_SESSION['SESSION']);
        $this->assertSame($GLOBALS['SESSION'], $SESSION);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);
    }

    public function test_sesskey() {
        global $USER;
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();

        \core\session\manager::init_empty_session();
        $this->assertObjectNotHasAttribute('sesskey', $USER);

        $sesskey = sesskey();
        $this->assertNotEmpty($sesskey);
        $this->assertSame($sesskey, $USER->sesskey);
        $this->assertSame($GLOBALS['USER'], $_SESSION['USER']);
        $this->assertSame($GLOBALS['USER'], $USER);

        $this->assertSame($sesskey, sesskey());

        // Test incomplete session init - the sesskeys should return random values.
        $_SESSION = array();
        unset($GLOBALS['USER']);
        unset($GLOBALS['SESSION']);

        $this->assertFalse(sesskey());
        $this->assertArrayNotHasKey('USER', $GLOBALS);
        $this->assertFalse(sesskey());
    }

    public function test_confirm_sesskey() {
        $this->resetAfterTest();

        $sesskey = sesskey();

        try {
            confirm_sesskey();
            $this->fail('Exception expected when sesskey not present');
        } catch (lion_exception $e) {
            $this->assertSame('missingparam', $e->errorcode);
        }

        $this->assertTrue(confirm_sesskey($sesskey));
        $this->assertFalse(confirm_sesskey('blahblah'));

        $_GET['sesskey'] = $sesskey;
        $this->assertTrue(confirm_sesskey());

        $_GET['sesskey'] = 'blah';
        $this->assertFalse(confirm_sesskey());
    }

    public function test_require_sesskey() {
        $this->resetAfterTest();

        $sesskey = sesskey();

        try {
            require_sesskey();
            $this->fail('Exception expected when sesskey not present');
        } catch (lion_exception $e) {
            $this->assertSame('missingparam', $e->errorcode);
        }

        $_GET['sesskey'] = $sesskey;
        require_sesskey();

        $_GET['sesskey'] = 'blah';
        try {
            require_sesskey();
            $this->fail('Exception expected when sesskey not incorrect');
        } catch (lion_exception $e) {
            $this->assertSame('invalidsesskey', $e->errorcode);
        }
    }
}
