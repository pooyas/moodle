<?php

/**
 * Unit tests for the wiki parser
 *
 * @package   mod
 * @subpackage wiki
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 *
 * 
 */

defined('LION_INTERNAL') || die;

global $CFG;
require_once($CFG->dirroot . '/mod/wiki/parser/parser.php');


class mod_wiki_wikiparser_test extends basic_testcase {

    function testCreoleMarkup() {
        $this->assertTestFiles('creole');
    }

    function testNwikiMarkup() {
        $this->assertTestFiles('nwiki');
    }

    function testHtmlMarkup() {
        $this->assertTestFiles('html');
    }

    private function assertTestFile($num, $markup) {
        if(!file_exists(__DIR__."/fixtures/input/$markup/$num") || !file_exists(__DIR__."/fixtures/output/$markup/$num")) {
            return false;
        }
        $input = file_get_contents(__DIR__."/fixtures/input/$markup/$num");
        $output = file_get_contents(__DIR__."/fixtures/output/$markup/$num");

        $result = wiki_parser_proxy::parse($input, $markup, array('pretty_print' => true));

        //removes line breaks to avoid line break encoding causing tests to fail.
        $result['parsed_text'] = preg_replace('~[\r\n]~', '', $result['parsed_text']);
        $output                = preg_replace('~[\r\n]~', '', $output);

        $this->assertEquals($output, $result['parsed_text']);
        return true;
    }

    private function assertTestFiles($markup) {
        $i = 1;
        while($this->assertTestFile($i, $markup)) {
            $i++;
        }
    }

    /**
     * Check that headings with special characters work as expected with HTML.
     *
     * - The heading itself is well displayed,
     * - The TOC heading is well display,
     * - The edit link points to the right page,
     * - The links properly works with get_section.
     */
    public function test_special_headings() {

        // First testing HTML markup.

        // Test section name using HTML entities.
        $input = '<h1>Code &amp; Test</h1>';
        $output = '<h1><a name="toc-1"></a>Code &amp; Test <a href="edit.php?pageid=&amp;section=Code+%26amp%3B+Test" '.
            'class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Code &amp; Test <a href="edit.php?pageid=&amp;section=Code+%26amp%3B+'.
            'Test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'html', 'Code &amp; Test');
        $actual = wiki_parser_proxy::parse($input, 'html');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Test section name using non-ASCII characters.
        $input = '<h1>Another áéíóúç€ test</h1>';
        $output = '<h1><a name="toc-1"></a>Another áéíóúç€ test <a href="edit.php?pageid=&amp;section=Another+%C'.
            '3%A1%C3%A9%C3%AD%C3%B3%C3%BA%C3%A7%E2%82%AC+test" class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Another áéíóúç€ test <a href="edit.php?pageid=&amp;section=Another+%C'.
            '3%A1%C3%A9%C3%AD%C3%B3%C3%BA%C3%A7%E2%82%AC+test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'html', 'Another áéíóúç€ test');
        $actual = wiki_parser_proxy::parse($input, 'html');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Test section name with a URL.
        $input = '<h1>Another http://lion.org test</h1>';
        $output = '<h1><a name="toc-1"></a>Another <a href="http://lion.org">http://lion.org</a> test <a href="edit.php'.
            '?pageid=&amp;section=Another+http%3A%2F%2Flion.org+test" class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Another http://lion.org test <a href="edit.php?pageid=&amp;section='.
            'Another+http%3A%2F%2Flion.org+test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'html', 'Another http://lion.org test');
        $actual = wiki_parser_proxy::parse($input, 'html', array(
            'link_callback' => '/mod/wiki/locallib.php:wiki_parser_link'
        ));
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Now going to test Creole markup.
        // Note that Creole uses links to the escaped version of the section.

        // Test section name using HTML entities.
        $input = '= Code & Test =';
        $output = '<h1><a name="toc-1"></a>Code &amp; Test <a href="edit.php?pageid=&amp;section=Code+%26amp%3B+Test" '.
            'class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Code &amp; Test <a href="edit.php?pageid=&amp;section=Code+%26amp%3B+'.
            'Test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'creole', 'Code &amp; Test');
        $actual = wiki_parser_proxy::parse($input, 'creole');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Test section name using non-ASCII characters.
        $input = '= Another áéíóúç€ test =';
        $output = '<h1><a name="toc-1"></a>Another áéíóúç€ test <a href="edit.php?pageid=&amp;section=Another+%C'.
            '3%A1%C3%A9%C3%AD%C3%B3%C3%BA%C3%A7%E2%82%AC+test" class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Another áéíóúç€ test <a href="edit.php?pageid=&amp;section=Another+%C'.
            '3%A1%C3%A9%C3%AD%C3%B3%C3%BA%C3%A7%E2%82%AC+test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'creole', 'Another áéíóúç€ test');
        $actual = wiki_parser_proxy::parse($input, 'creole');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Test section name with a URL, creole does not support linking links in a heading.
        $input = '= Another http://lion.org test =';
        $output = '<h1><a name="toc-1"></a>Another http://lion.org test <a href="edit.php'.
            '?pageid=&amp;section=Another+http%3A%2F%2Flion.org+test" class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Another http://lion.org test <a href="edit.php?pageid=&amp;section='.
            'Another+http%3A%2F%2Flion.org+test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'creole', 'Another http://lion.org test');
        $actual = wiki_parser_proxy::parse($input, 'creole');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Now going to test NWiki markup.
        // Note that Creole uses links to the escaped version of the section.

        // Test section name using HTML entities.
        $input = '= Code & Test =';
        $output = '<h1><a name="toc-1"></a>Code & Test <a href="edit.php?pageid=&amp;section=Code+%26+Test" '.
            'class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Code & Test <a href="edit.php?pageid=&amp;section=Code+%26+'.
            'Test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'nwiki', 'Code & Test');
        $actual = wiki_parser_proxy::parse($input, 'nwiki');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Test section name using non-ASCII characters.
        $input = '= Another áéíóúç€ test =';
        $output = '<h1><a name="toc-1"></a>Another áéíóúç€ test <a href="edit.php?pageid=&amp;section=Another+%C'.
            '3%A1%C3%A9%C3%AD%C3%B3%C3%BA%C3%A7%E2%82%AC+test" class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Another áéíóúç€ test <a href="edit.php?pageid=&amp;section=Another+%C'.
            '3%A1%C3%A9%C3%AD%C3%B3%C3%BA%C3%A7%E2%82%AC+test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'nwiki', 'Another áéíóúç€ test');
        $actual = wiki_parser_proxy::parse($input, 'nwiki');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);

        // Test section name with a URL, nwiki does not support linking links in a heading.
        $input = '= Another http://lion.org test =';
        $output = '<h1><a name="toc-1"></a>Another http://lion.org test <a href="edit.php'.
            '?pageid=&amp;section=Another+http%3A%2F%2Flion.org+test" class="wiki_edit_section">[edit]</a></h1>' . "\n";
        $toc = '<div class="wiki-toc"><p class="wiki-toc-title">Table of contents</p><p class="wiki-toc-section-1 '.
            'wiki-toc-section">1. <a href="#toc-1">Another http://lion.org test <a href="edit.php?pageid=&amp;section='.
            'Another+http%3A%2F%2Flion.org+test" class="wiki_edit_section">[edit]</a></a></p></div>';
        $section = wiki_parser_proxy::get_section($input, 'nwiki', 'Another http://lion.org test');
        $actual = wiki_parser_proxy::parse($input, 'nwiki');
        $this->assertEquals($output, $actual['parsed_text']);
        $this->assertEquals($toc, $actual['toc']);
        $this->assertNotEquals(false, $section);
    }

}
