<?php

defined('LION_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/webservice/tests/helpers.php');
require_once($CFG->dirroot . '/enrol/externallib.php');

/**
 * Role external PHPunit tests
 *
 * @package    core_enrol
 * @category   external
 * @copyright  2012 Jerome Mouneyrac
 * 
 * @since Lion 2.4
 */
class core_enrol_role_external_testcase extends externallib_advanced_testcase {

    /**
     * Tests set up
     */
    protected function setUp() {
        global $CFG;
        require_once($CFG->dirroot . '/enrol/externallib.php');
    }

    /**
     * Test assign_roles
     */
    public function test_assign_roles() {
        global $USER;

        $this->resetAfterTest(true);

        $course = self::getDataGenerator()->create_course();

        // Set the required capabilities by the external function.
        $context = context_course::instance($course->id);
        $roleid = $this->assignUserCapability('lion/role:assign', $context->id);
        $this->assignUserCapability('lion/course:view', $context->id, $roleid);

        // Add manager role to $USER.
        // So $USER is allowed to assign 'manager', 'editingteacher', 'teacher' and 'student'.
        role_assign(1, $USER->id, context_system::instance()->id);

        // Check the teacher role has not been assigned to $USER.
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 0);

        // Call the external function. Assign teacher role to $USER with contextid.
        core_role_external::assign_roles(array(
            array('roleid' => 3, 'userid' => $USER->id, 'contextid' => $context->id)));

        // Check the role has been assigned.
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 1);

        // Unassign role.
        role_unassign(3, $USER->id, $context->id);
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 0);

        // Call the external function. Assign teacher role to $USER.
        core_role_external::assign_roles(array(
            array('roleid' => 3, 'userid' => $USER->id, 'contextlevel' => "course", 'instanceid' => $course->id)));
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 1);

        // Call without required capability.
        $this->unassignUserCapability('lion/role:assign', $context->id, $roleid);
        $this->setExpectedException('lion_exception');
        $categories = core_role_external::assign_roles(
            array('roleid' => 3, 'userid' => $USER->id, 'contextid' => $context->id));
    }

    /**
     * Test unassign_roles
     */
    public function test_unassign_roles() {
        global $USER;

        $this->resetAfterTest(true);

        $course = self::getDataGenerator()->create_course();

        // Set the required capabilities by the external function.
        $context = context_course::instance($course->id);
        $roleid = $this->assignUserCapability('lion/role:assign', $context->id);
        $this->assignUserCapability('lion/course:view', $context->id, $roleid);

        // Add manager role to $USER.
        // So $USER is allowed to assign 'manager', 'editingteacher', 'teacher' and 'student'.
        role_assign(1, $USER->id, context_system::instance()->id);

        // Add teacher role to $USER on course context.
        role_assign(3, $USER->id, $context->id);

        // Check the teacher role has been assigned to $USER on course context.
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 1);

        // Call the external function. Unassign teacher role using contextid.
        core_role_external::unassign_roles(array(
            array('roleid' => 3, 'userid' => $USER->id, 'contextid' => $context->id)));

        // Check the role has been unassigned on course context.
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 0);

        // Add teacher role to $USER on course context.
        role_assign(3, $USER->id, $context->id);
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 1);

        // Call the external function. Unassign teacher role using context level and instanceid.
        core_role_external::unassign_roles(array(
            array('roleid' => 3, 'userid' => $USER->id, 'contextlevel' => "course", 'instanceid' => $course->id)));

        // Check the role has been unassigned on course context.
        $users = get_role_users(3, $context);
        $this->assertEquals(count($users), 0);

        // Call without required capability.
        $this->unassignUserCapability('lion/role:assign', $context->id, $roleid);
        $this->setExpectedException('lion_exception');
        $categories = core_role_external::unassign_roles(
            array('roleid' => 3, 'userid' => $USER->id, 'contextid' => $context->id));
    }
}