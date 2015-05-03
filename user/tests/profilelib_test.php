<?php

/**
 * Unit tests for user/profile/lib.php.
 *
 * @package core_user
 * @copyright 2015 Pooya Saeedi
 * @licensehttp://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

global $CFG;

/**
 * Unit tests for user/profile/lib.php.
 *
 * @package core_user
 * @copyright 2015 Pooya Saeedi
 * @licensehttp://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_user_profilelib_testcase extends advanced_testcase {
    /**
     * Tests profile_get_custom_fields function and checks it is consistent
     * with profile_user_record.
     */
    public function test_get_custom_fields() {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/user/profile/lib.php');

        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();

        // Add a custom field of textarea type.
        $id1 = $DB->insert_record('user_info_field', array(
                'shortname' => 'frogdesc', 'name' => 'Description of frog', 'categoryid' => 1,
                'datatype' => 'textarea'));

        // Check the field is returned.
        $result = profile_get_custom_fields();
        $this->assertArrayHasKey($id1, $result);
        $this->assertEquals('frogdesc', $result[$id1]->shortname);

        // Textarea types are not included in user data though, so if we
        // use the 'only in user data' parameter, there is still nothing.
        $this->assertArrayNotHasKey($id1, profile_get_custom_fields(true));

        // Check that profile_user_record returns same (no) fields.
        $this->assertObjectNotHasAttribute('frogdesc', profile_user_record($user->id));

        // Add another custom field, this time of normal text type.
        $id2 = $DB->insert_record('user_info_field', array(
                'shortname' => 'frogname', 'name' => 'Name of frog', 'categoryid' => 1,
                'datatype' => 'text'));

        // Check both are returned using normal option.
        $result = profile_get_custom_fields();
        $this->assertArrayHasKey($id2, $result);
        $this->assertEquals('frogname', $result[$id2]->shortname);

        // And check that only the one is returned the other way.
        $this->assertArrayHasKey($id2, profile_get_custom_fields(true));

        // Check profile_user_record returns same field.
        $this->assertObjectHasAttribute('frogname', profile_user_record($user->id));
    }

    /**
     * Make sure that all profile fields can be initialised without arguments.
     */
    public function test_default_constructor() {
        global $DB, $CFG;
        require_once($CFG->dirroot . '/user/profile/definelib.php');
        $datatypes = profile_list_datatypes();
        foreach ($datatypes as $datatype => $datatypename) {
            require_once($CFG->dirroot . '/user/profile/field/' .
                $datatype . '/field.class.php');
            $newfield = 'profile_field_' . $datatype;
            $formfield = new $newfield();
            $this->assertNotNull($formfield);
        }
    }
}
