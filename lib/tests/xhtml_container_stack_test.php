<?php

/**
 * Unit tests for xhtml stack.
 *
 * @package   core
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 *  (5)
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/outputlib.php');


/**
 * Unit tests for the xhtml_container_stack class.
 *
 * These tests assume that developer debug mode is on which is enforced by our phpunit integration.
 *
 * @copyright 2015 Pooya Saeedi
 * 
 */
class core_xhtml_container_stack_testcase extends advanced_testcase {
    public function test_push_then_pop() {
        // Set up.
        $stack = new xhtml_container_stack();
        // Exercise SUT.
        $stack->push('testtype', '</div>');
        $html = $stack->pop('testtype');
        // Verify outcome.
        $this->assertEquals('</div>', $html);
        $this->assertDebuggingNotCalled();
    }

    public function test_mismatched_pop_prints_warning() {
        // Set up.
        $stack = new xhtml_container_stack();
        $stack->push('testtype', '</div>');
        // Exercise SUT.
        $html = $stack->pop('mismatch');
        // Verify outcome.
        $this->assertEquals('</div>', $html);
        $this->assertDebuggingCalled();
    }

    public function test_pop_when_empty_prints_warning() {
        // Set up.
        $stack = new xhtml_container_stack();
        // Exercise SUT.
        $html = $stack->pop('testtype');
        // Verify outcome.
        $this->assertEquals('', $html);
        $this->assertDebuggingCalled();
    }

    public function test_correct_nesting() {
        // Set up.
        $stack = new xhtml_container_stack();
        // Exercise SUT.
        $stack->push('testdiv', '</div>');
        $stack->push('testp', '</p>');
        $html2 = $stack->pop('testp');
        $html1 = $stack->pop('testdiv');
        // Verify outcome.
        $this->assertEquals('</p>', $html2);
        $this->assertEquals('</div>', $html1);
        $this->assertDebuggingNotCalled();
    }

    public function test_pop_all_but_last() {
        // Set up.
        $stack = new xhtml_container_stack();
        $stack->push('test1', '</h1>');
        $stack->push('test2', '</h2>');
        $stack->push('test3', '</h3>');
        // Exercise SUT.
        $html = $stack->pop_all_but_last();
        // Verify outcome.
        $this->assertEquals('</h3></h2>', $html);
        $this->assertDebuggingNotCalled();
        // Tear down.
        $stack->discard();
    }

    public function test_pop_all_but_last_only_one() {
        // Set up.
        $stack = new xhtml_container_stack();
        $stack->push('test1', '</h1>');
        // Exercise SUT.
        $html = $stack->pop_all_but_last();
        // Verify outcome.
        $this->assertEquals('', $html);
        $this->assertDebuggingNotCalled();
        // Tear down.
        $stack->discard();
    }

    public function test_pop_all_but_last_empty() {
        // Set up.
        $stack = new xhtml_container_stack();
        // Exercise SUT.
        $html = $stack->pop_all_but_last();
        // Verify outcome.
        $this->assertEquals('', $html);
        $this->assertDebuggingNotCalled();
    }

    public function test_discard() {
        // Set up.
        $stack = new xhtml_container_stack();
        $stack->push('test1', '</somethingdistinctive>');
        $stack->discard();
        // Exercise SUT.
        $stack = null;
        // Verify outcome.
        $this->assertDebuggingNotCalled();
    }
}
