<?php

/**
 * @package   core_backup
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include all the needed stuff
global $CFG;
require_once($CFG->dirroot . '/backup/util/xml/output/xml_output.class.php');
require_once($CFG->dirroot . '/backup/util/xml/output/memory_xml_output.class.php');
require_once($CFG->dirroot . '/backup/util/xml/output/file_xml_output.class.php');

/*
 * xml_output tests (base, memory and file)
 */
class xml_output_test extends advanced_testcase {

    /*
     * test memory_xml_output
     */
    function test_memory_xml_output() {
        // Instantiate xml_output
        $xo = new memory_xml_output();
        $this->assertTrue($xo instanceof xml_output);

        // Try to write some contents before starting it
        $xo = new memory_xml_output();
        try {
            $xo->write('test');
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_not_started');
        }

        // Try to set buffer size if unsupported
        $xo = new memory_xml_output();
        try {
            $xo->set_buffersize(8192);
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_buffer_nosupport');
        }

        // Try to set buffer after start
        $xo = new memory_xml_output();
        $xo->start();
        try {
            $xo->set_buffersize(8192);
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_already_started');
        }

        // Try to stop output before starting it
        $xo = new memory_xml_output();
        try {
            $xo->stop();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_not_started');
        }

        // Try to debug_info() before starting
        $xo = new memory_xml_output();
        try {
            $xo->debug_info();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_not_stopped');
        }

        // Start output twice
        $xo = new memory_xml_output();
        $xo->start();
        try {
            $xo->start();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_already_started');
        }

        // Try to debug_info() before stoping
        $xo = new memory_xml_output();
        $xo->start();
        try {
            $xo->debug_info();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_not_stopped');
        }

        // Stop output twice
        $xo = new memory_xml_output();
        $xo->start();
        $xo->stop();
        try {
            $xo->stop();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_not_started');
        }

        // Try to re-start after stop
        $xo = new memory_xml_output();
        $xo->start();
        $xo->stop();
        try {
            $xo->start();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_already_stopped');
        }

        // Try to get contents before stopping
        $xo = new memory_xml_output();
        $xo->start();
        try {
            $xo->get_allcontents();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'xml_output_not_stopped');
        }

        // Write some contents and check them
        $xo = new memory_xml_output();
        $xo->start();
        $xo->write('first test');
        $xo->stop();
        $this->assertEquals('first test', $xo->get_allcontents());

        // Write 3 times and check them
        $xo = new memory_xml_output();
        $xo->start();
        $xo->write('first test');
        $xo->write(', sencond test');
        $xo->write(', third test');
        $xo->stop();
        $this->assertEquals('first test, sencond test, third test', $xo->get_allcontents());

        // Write some line feeds, tabs and friends
        $string = "\n\r\tcrazy test\n\r\t";
        $xo = new memory_xml_output();
        $xo->start();
        $xo->write($string);
        $xo->stop();
        $this->assertEquals($string, $xo->get_allcontents());

        // Write some UTF-8 chars
        $string = 'áéíóú';
        $xo = new memory_xml_output();
        $xo->start();
        $xo->write($string);
        $xo->stop();
        $this->assertEquals($string, $xo->get_allcontents());

        // Write some empty content
        $xo = new memory_xml_output();
        $xo->start();
        $xo->write('Hello ');
        $xo->write(null);
        $xo->write(false);
        $xo->write('');
        $xo->write('World');
        $xo->write(null);
        $xo->stop();
        $this->assertEquals('Hello World', $xo->get_allcontents());

        // Get debug info
        $xo = new memory_xml_output();
        $xo->start();
        $xo->write('01234');
        $xo->write('56789');
        $xo->stop();
        $this->assertEquals('0123456789', $xo->get_allcontents());
        $debug = $xo->debug_info();
        $this->assertTrue(is_array($debug));
        $this->assertTrue(array_key_exists('sent', $debug));
        $this->assertEquals($debug['sent'], 10);
    }

    /*
     * test file_xml_output
     */
    function test_file_xml_output() {
        global $CFG;

        $this->resetAfterTest();

        $file = $CFG->tempdir . '/test/test_file_xml_output.txt';
        // Remove the test dir and any content
        @remove_dir(dirname($file));
        // Recreate test dir
        if (!check_dir_exists(dirname($file), true, true)) {
            throw new lion_exception('error_creating_temp_dir', 'error', dirname($file));
        }

        // Instantiate xml_output
        $xo = new file_xml_output($file);
        $this->assertTrue($xo instanceof xml_output);

        // Try to init file in (near) impossible path
        $file = $CFG->tempdir . '/test_azby/test_file_xml_output.txt';
        $xo = new file_xml_output($file);
        try {
            $xo->start();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'directory_not_exists');
        }

        // Try to init file already existing
        $file = $CFG->tempdir . '/test/test_file_xml_output.txt';
        file_put_contents($file, 'createdtobedeleted'); // create file manually
        $xo = new file_xml_output($file);
        try {
            $xo->start();
            $this->assertTrue(false, 'xml_output_exception expected');
        } catch (exception $e) {
            $this->assertTrue($e instanceof xml_output_exception);
            $this->assertEquals($e->errorcode, 'file_already_exists');
        }
        unlink($file); // delete file

        // Send some output and check
        $file = $CFG->tempdir . '/test/test_file_xml_output.txt';
        $xo = new file_xml_output($file);
        $xo->start();
        $xo->write('first text');
        $xo->stop();
        $this->assertEquals('first text', file_get_contents($file));
        unlink($file); // delete file

        // With buffer of 4 bytes, send 3 contents of 3 bytes each
        // so we force both buffering and last write on stop
        $file = $CFG->tempdir . '/test/test_file_xml_output.txt';
        $xo = new file_xml_output($file);
        $xo->set_buffersize(5);
        $xo->start();
        $xo->write('123');
        $xo->write('456');
        $xo->write('789');
        $xo->stop();
        $this->assertEquals('123456789',  file_get_contents($file));
        unlink($file); // delete file

        // Write some line feeds, tabs and friends
        $file = $CFG->tempdir . '/test/test_file_xml_output.txt';
        $string = "\n\r\tcrazy test\n\r\t";
        $xo = new file_xml_output($file);
        $xo->start();
        $xo->write($string);
        $xo->stop();
        $this->assertEquals($string, file_get_contents($file));
        unlink($file); // delete file

        // Write some UTF-8 chars
        $file = $CFG->tempdir . '/test/test_file_xml_output.txt';
        $string = 'áéíóú';
        $xo = new file_xml_output($file);
        $xo->start();
        $xo->write($string);
        $xo->stop();
        $this->assertEquals($string, file_get_contents($file));
        unlink($file); // delete file

        // Remove the test dir and any content
        @remove_dir(dirname($file));
    }
}
