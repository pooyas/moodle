<?php

/**
 * Test \core\dml\recordset_walk.
 *
 * @package    core
 * @category   dml
 * @copyright  2015 David Monllao
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Test case for recordset_walk.
 *
 * @package    core
 * @category   dml
 * @copyright  2015 David Monllao
 * 
 */
class core_recordset_walk_testcase extends advanced_testcase {

    public function setUp() {
        parent::setUp();
        $this->resetAfterTest();
    }

    public function test_no_data() {
        global $DB;

        $recordset = $DB->get_recordset('assign');
        $walker = new \core\dml\recordset_walk($recordset, array($this, 'simple_callback'));
        $this->assertEquals(0, iterator_count($walker));
        $this->assertFalse($walker->valid());
        foreach ($walker as $data) {
            // No error here.
        }
        $walker->close();
    }

    public function test_simple_callback() {
        global $DB;

        $generator = $this->getDataGenerator()->get_plugin_generator('mod_assign');
        $courses = array();
        for ($i = 0; $i < 10; $i++) {
            $courses[$i] = $generator->create_instance(array('course' => SITEID));
        }

        // Simple iteration.
        $recordset = $DB->get_recordset('assign');
        $walker = new \core\dml\recordset_walk($recordset, array($this, 'simple_callback'));
        $this->assertEquals(10, iterator_count($walker));
        foreach ($walker as $data) {
            // Checking that the callback is being executed on each iteration.
            $this->assertEquals($data->id . ' potatoes', $data->newfield);
        }
        // No exception if we double-close.
        $walker->close();
    }

    public function test_extra_params_callback() {
        global $DB;

        $generator = $this->getDataGenerator()->get_plugin_generator('mod_assign');
        $courses = array();
        for ($i = 0; $i < 10; $i++) {
            $courses[$i] = $generator->create_instance(array('course' => SITEID));
        }

        // Iteration with extra callback arguments.
        $recordset = $DB->get_recordset('assign');
        $walker = new \core\dml\recordset_walk(
            $recordset,
            array($this, 'extra_callback'),
            array('brown' => 'onions')
        );
        $this->assertEquals(10, iterator_count($walker));
        foreach ($walker as $data) {
            // Checking that the callback is being executed on each
            // iteration and the param is being passed.
            $this->assertEquals('onions', $data->brown);
        }
        $walker->close();
    }

    /**
     * Simple callback requiring 1 row fields.
     *
     * @param stdClass $data
     * @return \Traversable
     */
    public function simple_callback($data) {
        $data->newfield = $data->id . ' potatoes';
        return $data;
    }

    /**
     * Callback requiring 1 row fields + other params.
     *
     * @param stdClass $data
     * @param mixed $extra
     * @return \Traversable
     */
    public function extra_callback($data, $extra) {
        $data->brown = $extra['brown'];
        return $data;
    }
}
