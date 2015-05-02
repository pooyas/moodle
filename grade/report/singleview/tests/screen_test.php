<?php

/**
 * Unit tests for gradereport_singleview screen class.
 *
 * @package    gradereport_singleview
 * @category   test
 * @copyright  2014 onwards Simey Lameze <simey@lion.com>
 * 
 */


require_once(__DIR__ . '/fixtures/screen.php');

defined('LION_INTERNAL') || die();
/**
 * Tests for screen class.
 *
 * Class gradereport_singleview_screen_testcase.
 */
class gradereport_singleview_screen_testcase extends advanced_testcase {

    /**
     * Test load_users method.
     */
    public function test_load_users() {
        global $DB;

        $this->setAdminUser();
        $this->resetAfterTest(true);

        $roleteacher = $DB->get_record('role', array('shortname' => 'teacher'), '*', MUST_EXIST);

        // Create a course, users and groups.
        $course = $this->getDataGenerator()->create_course();
        $coursecontext = context_course::instance($course->id);
        $group = $this->getDataGenerator()->create_group(array('courseid' => $course->id));
        $teacher = $this->getDataGenerator()->create_user();
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();
        $this->getDataGenerator()->enrol_user($teacher->id, $course->id, $roleteacher->id);
        $this->getDataGenerator()->enrol_user($user1->id, $course->id);
        $this->getDataGenerator()->enrol_user($user2->id, $course->id);
        $this->getDataGenerator()->create_group_member(array('groupid' => $group->id, 'userid' => $teacher->id));
        $this->getDataGenerator()->create_group_member(array('groupid' => $group->id, 'userid' => $user1->id));
        $this->getDataGenerator()->create_group_member(array('groupid' => $group->id, 'userid' => $user2->id));

        $screentest = new gradereport_singleview_screen_testable($course->id, 0, $group->id);
        $groupusers = $screentest->test_load_users();
        $this->assertCount(2, $groupusers);

        // Now, let's suspend the enrolment of a user. Should return only one user.
        $this->getDataGenerator()->enrol_user($user2->id, $course->id, $roleteacher->id, 'manual', 0, 0, ENROL_USER_SUSPENDED);
        $users = $screentest->test_load_users();
        $this->assertCount(1, $users);

        // Change the viewsuspendedusers capabilities and set the user preference to display suspended users.
        assign_capability('lion/course:viewsuspendedusers', CAP_ALLOW, $roleteacher->id, $coursecontext, true);
        set_user_preference('grade_report_showonlyactiveenrol', false, $teacher);
        accesslib_clear_all_caches_for_unit_testing();
        $this->setUser($teacher);
        $screentest = new gradereport_singleview_screen_testable($course->id, 0, $group->id);
        $users = $screentest->test_load_users();
        $this->assertCount(2, $users);

        // Change the capability again, now the user can't see the suspended enrolments.
        assign_capability('lion/course:viewsuspendedusers', CAP_PROHIBIT, $roleteacher->id, $coursecontext, true);
        set_user_preference('grade_report_showonlyactiveenrol', false, $teacher);
        accesslib_clear_all_caches_for_unit_testing();
        $users = $screentest->test_load_users();
        $this->assertCount(1, $users);

        // Now, activate the user enrolment again. We shall get 2 users now.
        $this->getDataGenerator()->enrol_user($user2->id, $course->id, $roleteacher->id, 'manual', 0, 0, ENROL_USER_ACTIVE);
        $users = $screentest->test_load_users();
        $this->assertCount(2, $users);
    }
}