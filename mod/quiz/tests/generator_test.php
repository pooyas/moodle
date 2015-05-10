<?php

/**
 * PHPUnit data generator tests
 *
 * @package    mod
 * @subpackage quiz
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();


/**
 * PHPUnit data generator testcase
 *
 */
class mod_quiz_generator_testcase extends advanced_testcase {
    public function test_generator() {
        global $DB, $SITE;

        $this->resetAfterTest(true);

        $this->assertEquals(0, $DB->count_records('quiz'));

        /** @var mod_quiz_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');
        $this->assertInstanceOf('mod_quiz_generator', $generator);
        $this->assertEquals('quiz', $generator->get_modulename());

        $generator->create_instance(array('course'=>$SITE->id));
        $generator->create_instance(array('course'=>$SITE->id));
        $quiz = $generator->create_instance(array('course'=>$SITE->id));
        $this->assertEquals(3, $DB->count_records('quiz'));

        $cm = get_coursemodule_from_instance('quiz', $quiz->id);
        $this->assertEquals($quiz->id, $cm->instance);
        $this->assertEquals('quiz', $cm->modname);
        $this->assertEquals($SITE->id, $cm->course);

        $context = context_module::instance($cm->id);
        $this->assertEquals($quiz->cmid, $context->instanceid);
    }
}
