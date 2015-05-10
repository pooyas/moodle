<?php

/**
 * mod_survey generator tests
 *
 * @package    mod
 * @subpackage survey
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Genarator tests class for mod_survey.
 *
 */
class mod_survey_generator_testcase extends advanced_testcase {

    public function test_create_instance() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();

        $this->assertFalse($DB->record_exists('survey', array('course' => $course->id)));
        $survey = $this->getDataGenerator()->create_module('survey', array('course' => $course));
        $records = $DB->get_records('survey', array('course' => $course->id), 'id');
        $this->assertEquals(1, count($records));
        $this->assertTrue(array_key_exists($survey->id, $records));

        $params = array('course' => $course->id, 'name' => 'Another survey');
        $survey = $this->getDataGenerator()->create_module('survey', $params);
        $records = $DB->get_records('survey', array('course' => $course->id), 'id');
        $this->assertEquals(2, count($records));
        $this->assertEquals('Another survey', $records[$survey->id]->name);
    }

    public function test_create_instance_with_template() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();
        $templates = $DB->get_records_menu('survey', array('template' => 0), 'name', 'id, name');
        $firsttemplateid = key($templates);

        // By default survey is created with the first available template.
        $survey = $this->getDataGenerator()->create_module('survey', array('course' => $course));
        $record = $DB->get_record('survey', array('id' => $survey->id));
        $this->assertEquals($firsttemplateid, $record->template);

        // Survey can be created specifying the template id.
        $tmplid = array_search('ciqname', $templates);
        $survey = $this->getDataGenerator()->create_module('survey', array('course' => $course,
            'template' => $tmplid));
        $record = $DB->get_record('survey', array('id' => $survey->id));
        $this->assertEquals($tmplid, $record->template);

        // Survey can be created specifying the template name instead of id.
        $survey = $this->getDataGenerator()->create_module('survey', array('course' => $course,
            'template' => 'collesaname'));
        $record = $DB->get_record('survey', array('id' => $survey->id));
        $this->assertEquals(array_search('collesaname', $templates), $record->template);

        // Survey can not be created specifying non-existing template id or name.
        try {
            $this->getDataGenerator()->create_module('survey', array('course' => $course,
                'template' => 87654));
            $this->fail('Exception about non-existing numeric template is expected');
        } catch (Exception $e) {}
        try {
            $this->getDataGenerator()->create_module('survey', array('course' => $course,
                'template' => 'nonexistingcode'));
            $this->fail('Exception about non-existing string template is expected');
        } catch (Exception $e) {}
    }
}
