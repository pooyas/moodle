<?php

/**
 * Legacy SimpleTest layer.
 *
 * @deprecated since 2.3
 * @package    core
 * @category   phpunit
 * @author     Petr Skoda
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */


/**
 * Simplified emulation test case for legacy SimpleTest.
 *
 * Note: this is supposed to work for very simple tests only.
 *
 * @deprecated since 2.3
 * @package    core
 * @category   phpunit
 * @author     Petr Skoda
 * @copyright  2012 Petr Skoda {@link http://skodak.org}
 * 
 */
abstract class UnitTestCase extends PHPUnit_Framework_TestCase {

    /**
     * @deprecated since 2.3
     * @param bool $expected
     * @param string $message
     * @return void
     */
    public function expectException($expected, $message = '') {
        // alternatively use phpdocs: @expectedException ExceptionClassName
        if (!$expected) {
            return;
        }
        $this->setExpectedException('lion_exception', $message);
    }

    /**
     * @deprecated since 2.3
     * @param bool $expected
     * @param string $message
     * @return void
     */
    public function expectError($expected = false, $message = '') {
        // alternatively use phpdocs: @expectedException PHPUnit_Framework_Error
        if (!$expected) {
            return;
        }
        $this->setExpectedException('PHPUnit_Framework_Error', $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $actual
     * @param string $messages
     * @return void
     */
    public static function assertTrue($actual, $messages = '') {
        parent::assertTrue((bool)$actual, $messages);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $actual
     * @param string $messages
     * @return void
     */
    public static function assertFalse($actual, $messages = '') {
        parent::assertFalse((bool)$actual, $messages);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     */
    public static function assertEqual($expected, $actual, $message = '') {
        parent::assertEquals($expected, $actual, $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $expected
     * @param mixed $actual
     * @param float|int $margin
     * @param string $message
     * @return void
     */
    public static function assertWithinMargin($expected, $actual, $margin, $message = '') {
        parent::assertEquals($expected, $actual, '', $margin, $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     */
    public static function assertNotEqual($expected, $actual, $message = '') {
        parent::assertNotEquals($expected, $actual, $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     */
    public static function assertIdentical($expected, $actual, $message = '') {
        parent::assertSame($expected, $actual, $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @return void
     */
    public static function assertNotIdentical($expected, $actual, $message = '') {
        parent::assertNotSame($expected, $actual, $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $actual
     * @param mixed $expected
     * @param string $message
     * @return void
     */
    public static function assertIsA($actual, $expected, $message = '') {
        if ($expected === 'array') {
            parent::assertEquals('array', gettype($actual), $message);
        } else {
            parent::assertInstanceOf($expected, $actual, $message);
        }
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $pattern
     * @param mixed $string
     * @param string $message
     * @return void
     */
    public static function assertPattern($pattern, $string, $message = '') {
        parent::assertRegExp($pattern, $string, $message);
    }

    /**
     * @deprecated since 2.3
     * @static
     * @param mixed $pattern
     * @param mixed $string
     * @param string $message
     * @return void
     */
    public static function assertNotPattern($pattern, $string, $message = '') {
        parent::assertNotRegExp($pattern, $string, $message);
    }
}
