<?php

defined('LION_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');
require_once($CFG->dirroot . '/enrol/externallib.php');

/**
 * Enrol external PHPunit tests
 *
 * @package    core_enrol
 * @category   external
 * @copyright  2015 Pooya Saeedi
 * 
 * @since Lion 2.4
 */
class core_enrol_externallib_testcase extends externallib_advanced_testcase {

    /**
     * Test get_enrolled_users
     */
    public function test_get_enrolled_users() {
        global $USER;

        $this->resetAfterTest(true);

        $course = self::getDataGenerator()->create_course();
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $this->setUser($user3);

        // Set the required capabilities by the external function.
        $context = context_course::instance($course->id);
        $roleid = $this->assignUserCapability('lion/course:viewparticipants', $context->id);
        $this->assignUserCapability('lion/user:viewdetails', $context->id, $roleid);

        // Enrol the users in the course.
        $this->getDataGenerator()->enrol_user($user1->id, $course->id, $roleid, 'manual');
        $this->getDataGenerator()->enrol_user($user2->id, $course->id, $roleid, 'manual');
        $this->getDataGenerator()->enrol_user($user3->id, $course->id, $roleid, 'manual');

        // Call the external function.
        $enrolledusers = core_enrol_external::get_enrolled_users($course->id);

        // We need to execute the return values cleaning process to simulate the web service server.
        $enrolledusers = external_api::clean_returnvalue(core_enrol_external::get_enrolled_users_returns(), $enrolledusers);

        // Check the result set.
        $this->assertEquals(3, count($enrolledusers));
        $this->assertArrayHasKey('email', $enrolledusers[0]);

        // Call the function with some parameters set.
        $enrolledusers = core_enrol_external::get_enrolled_users($course->id, array(
            array('name' => 'limitfrom', 'value' => 2),
            array('name' => 'limitnumber', 'value' => 1),
            array('name' => 'userfields', 'value' => 'id')
        ));

        // We need to execute the return values cleaning process to simulate the web service server.
        $enrolledusers = external_api::clean_returnvalue(core_enrol_external::get_enrolled_users_returns(), $enrolledusers);

        // Check the result set, we should only get the 3rd result, which is $user3.
        $this->assertCount(1, $enrolledusers);
        $this->assertEquals($user3->id, $enrolledusers[0]['id']);
        $this->assertArrayHasKey('id', $enrolledusers[0]);
        $this->assertArrayNotHasKey('email', $enrolledusers[0]);

        // Call without required capability.
        $this->unassignUserCapability('lion/course:viewparticipants', $context->id, $roleid);
        $this->setExpectedException('lion_exception');
        $categories = core_enrol_external::get_enrolled_users($course->id);
    }

    /**
     * Test get_users_courses
     */
    public function test_get_users_courses() {
        global $USER;

        $this->resetAfterTest(true);

        $course1 = self::getDataGenerator()->create_course();
        $course2 = self::getDataGenerator()->create_course();
        $courses = array($course1, $course2);

        // Enrol $USER in the courses.
        // We use the manual plugin.
        $roleid = null;
        foreach ($courses as $course) {
            $context = context_course::instance($course->id);
            $roleid = $this->assignUserCapability('lion/course:viewparticipants',
                    $context->id, $roleid);

            $this->getDataGenerator()->enrol_user($USER->id, $course->id, $roleid, 'manual');
        }

        // Call the external function.
        $enrolledincourses = core_enrol_external::get_users_courses($USER->id);

        // We need to execute the return values cleaning process to simulate the web service server.
        $enrolledincourses = external_api::clean_returnvalue(core_enrol_external::get_users_courses_returns(), $enrolledincourses);

        // Check we retrieve the good total number of enrolled users.
        $this->assertEquals(2, count($enrolledincourses));
    }

    /**
     * Test get_enrolled_users_with_capability
     */
    public function test_get_enrolled_users_with_capability () {
        global $DB, $USER;

        $this->resetAfterTest(true);

        $user1 = $this->getDataGenerator()->create_user();

        $coursedata['idnumber'] = 'idnumbercourse1';
        $coursedata['fullname'] = 'Lightwork Course 1';
        $coursedata['summary'] = 'Lightwork Course 1 description';
        $coursedata['summaryformat'] = FORMAT_LION;
        $course1  = self::getDataGenerator()->create_course($coursedata);

        // Create a manual enrolment record.
        $manual_enrol_data['enrol'] = 'manual';
        $manual_enrol_data['status'] = 0;
        $manual_enrol_data['courseid'] = $course1->id;
        $enrolid = $DB->insert_record('enrol', $manual_enrol_data);

        // Create the users and give them capabilities in the course context.
        $context = context_course::instance($course1->id);
        $roleid = $this->assignUserCapability('lion/course:viewparticipants', $context->id, 3);

        // Create 2 students.
        $student1 = self::getDataGenerator()->create_user();
        $student2 = self::getDataGenerator()->create_user();

        // Give the capability to student2.
        assign_capability('lion/course:viewparticipants', CAP_ALLOW, 3, $context->id);
        role_assign(3, $student2->id, $context->id);
        accesslib_clear_all_caches_for_unit_testing();

        // Enrol both the user and the students in the course.
        $user_enrolment_data['status'] = 0;
        $user_enrolment_data['enrolid'] = $enrolid;
        $user_enrolment_data['userid'] = $USER->id;
        $DB->insert_record('user_enrolments', $user_enrolment_data);

        $user_enrolment_data['status'] = 0;
        $user_enrolment_data['enrolid'] = $enrolid;
        $user_enrolment_data['userid'] = $student1->id;
        $DB->insert_record('user_enrolments', $user_enrolment_data);

        $user_enrolment_data['status'] = 0;
        $user_enrolment_data['enrolid'] = $enrolid;
        $user_enrolment_data['userid'] = $student2->id;
        $DB->insert_record('user_enrolments', $user_enrolment_data);

        $params = array("coursecapabilities" => array('courseid' => $course1->id,
            'capabilities' => array('lion/course:viewparticipants')));
        $options = array();
        $result = core_enrol_external::get_enrolled_users_with_capability($params, $options);

        // We need to execute the return values cleaning process to simulate the web service server.
        $result = external_api::clean_returnvalue(core_enrol_external::get_enrolled_users_with_capability_returns(), $result);

        // Check an array containing the expected user for the course capability is returned.
        $expecteduserlist = $result[0];
        $this->assertEquals($course1->id, $expecteduserlist['courseid']);
        $this->assertEquals('lion/course:viewparticipants', $expecteduserlist['capability']);
        $this->assertEquals(2, count($expecteduserlist['users']));

        // Now doing the query again with options.
        $params = array(
            "coursecapabilities" => array(
                'courseid' => $course1->id,
                'capabilities' => array('lion/course:viewparticipants')
            )
        );
        $options = array(
            array('name' => 'limitfrom', 'value' => 1),
            array('name' => 'limitnumber', 'value' => 1),
            array('name' => 'userfields', 'value' => 'id')
        );

        $result = core_enrol_external::get_enrolled_users_with_capability($params, $options);

        // We need to execute the return values cleaning process to simulate the web service server.
        $result = external_api::clean_returnvalue(core_enrol_external::get_enrolled_users_with_capability_returns(), $result);

        // Check an array containing the expected user for the course capability is returned.
        $expecteduserlist = $result[0]['users'];
        $expecteduser = reset($expecteduserlist);
        $this->assertEquals(1, count($expecteduserlist));
        $this->assertEquals($student2->id, $expecteduser['id']);
    }

    /**
     * Test get_course_enrolment_methods
     */
    public function test_get_course_enrolment_methods() {
        global $DB;

        $this->resetAfterTest(true);

        // Get enrolment plugins.
        $selfplugin = enrol_get_plugin('self');
        $this->assertNotEmpty($selfplugin);
        $manualplugin = enrol_get_plugin('manual');
        $this->assertNotEmpty($manualplugin);

        $studentrole = $DB->get_record('role', array('shortname'=>'student'));
        $this->assertNotEmpty($studentrole);

        $course1 = self::getDataGenerator()->create_course();
        $course2 = self::getDataGenerator()->create_course();

        // Add enrolment methods for course.
        $instanceid1 = $selfplugin->add_instance($course1, array('status' => ENROL_INSTANCE_ENABLED,
                                                                'name' => 'Test instance 1',
                                                                'customint6' => 1,
                                                                'roleid' => $studentrole->id));
        $instanceid2 = $selfplugin->add_instance($course1, array('status' => ENROL_INSTANCE_DISABLED,
                                                                'name' => 'Test instance 2',
                                                                'roleid' => $studentrole->id));

        $instanceid3 = $manualplugin->add_instance($course1, array('status' => ENROL_INSTANCE_ENABLED,
                                                                'name' => 'Test instance 3'));

        $enrolmentmethods = $DB->get_records('enrol', array('courseid' => $course1->id, 'status' => ENROL_INSTANCE_ENABLED));
        $this->assertCount(2, $enrolmentmethods);

        // Check if information is returned.
        $enrolmentmethods = core_enrol_external::get_course_enrolment_methods($course1->id);
        // Enrolment information is currently returned by self enrolment plugin, so count == 1.
        // This should be changed as we implement get_enrol_info() for other enrolment plugins.
        $this->assertCount(1, $enrolmentmethods);

        $enrolmentmethod = $enrolmentmethods[0];
        $this->assertEquals($course1->id, $enrolmentmethod['courseid']);
        $this->assertEquals('self', $enrolmentmethod['type']);
        $this->assertTrue($enrolmentmethod['status']);
        $this->assertFalse(isset($enrolmentmethod['wsfunction']));

        $instanceid4 = $selfplugin->add_instance($course2, array('status' => ENROL_INSTANCE_ENABLED,
                                                                'name' => 'Test instance 4',
                                                                'roleid' => $studentrole->id,
                                                                'customint6' => 1,
                                                                'password' => 'test'));
        $enrolmentmethods = core_enrol_external::get_course_enrolment_methods($course2->id);
        $this->assertCount(1, $enrolmentmethods);

        $enrolmentmethod = $enrolmentmethods[0];
        $this->assertEquals($course2->id, $enrolmentmethod['courseid']);
        $this->assertEquals('self', $enrolmentmethod['type']);
        $this->assertTrue($enrolmentmethod['status']);
        $this->assertEquals('enrol_self_get_instance_info', $enrolmentmethod['wsfunction']);
    }
}
