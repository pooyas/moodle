<?php

/**
 * Data generators tests
 *
 * @package    core
 * @subpackage questionengine
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * Test data generator
 *
 */
class core_question_generator_testcase extends advanced_testcase {
    public function test_create() {
        global $DB;

        $this->resetAfterTest();
        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');

        $count = $DB->count_records('question_categories');

        $cat = $generator->create_question_category();
        $this->assertEquals($count + 1, $DB->count_records('question_categories'));

        $cat = $generator->create_question_category(array(
                'name' => 'My category', 'sortorder' => 1));
        $this->assertSame('My category', $cat->name);
        $this->assertSame(1, $cat->sortorder);
    }
}
