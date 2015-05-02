<?php

/**
 * Unit tests for the URL repository.
 *
 * @package   repository_url
 * @copyright 2014 John Okely
 * 
 */

defined('LION_INTERNAL') || die;

global $CFG;
require_once($CFG->dirroot . '/repository/url/lib.php');


/**
 * URL repository test case.
 *
 * @copyright 2014 John Okely
 * 
 */
class repository_url_lib_testcase extends advanced_testcase {

    /**
     * Check that the url escaper performs as expected
     */
    public function test_escape_url() {
        $this->resetAfterTest();

        $repoid = $this->getDataGenerator()->create_repository('url')->id;

        $conversions = array(
                'http://example.com/test_file.png' => 'http://example.com/test_file.png',
                'http://example.com/test%20file.png' => 'http://example.com/test%20file.png',
                'http://example.com/test file.png' => 'http://example.com/test%20file.png',
                'http://example.com/test file.png?query=string+test&more=string+tests' =>
                    'http://example.com/test%20file.png?query=string+test&more=string+tests',
                'http://example.com/?tag=<p>' => 'http://example.com/?tag=%3Cp%3E',
                'http://example.com/"quoted".txt' => 'http://example.com/%22quoted%22.txt',
                'http://example.com/\'quoted\'.txt' => 'http://example.com/%27quoted%27.txt',
                '' => ''
            );

        foreach ($conversions as $input => $expected) {
            // The constructor uses a optional_param, so we need to hack $_GET.
            $_GET['file'] = $input;
            $repository = new repository_url($repoid);
            $this->assertSame($expected, $repository->file_url);
        }

        $exceptions = array(
                '%' => true,
                '!' => true,
                '!https://download.lion.org/unittest/test.jpg' => true,
                'https://download.lion.org/unittest/test.jpg' => false
            );

        foreach ($exceptions as $input => $expected) {
            $caughtexception = false;
            try {
                // The constructor uses a optional_param, so we need to hack $_GET.
                $_GET['file'] = $input;
                $repository = new repository_url($repoid);
                $repository->get_listing();
            } catch (repository_exception $e) {
                if ($e->errorcode == 'validfiletype') {
                    $caughtexception = true;
                }
            }
            $this->assertSame($expected, $caughtexception);
        }

        unset($_GET['file']);
    }

}
