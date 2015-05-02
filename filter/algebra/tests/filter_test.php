<?php

/**
 * Unit test for the filter_algebra
 *
 * @package    filter_algebra
 * @category   phpunit
 * @copyright  2012 Tim Hunt
 * 
 */

defined('LION_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/filter/algebra/filter.php');


/**
 * Unit tests for filter_algebra.
 *
 * Note that this only tests some of the filter logic. It does not acutally test
 * the normal case of the filter working, because I cannot make it work on my
 * test server, and if it does not work here, it probably does not also work
 * for other people. A failing test will be irritating noise.
 *
 * @copyright  2012 Tim Hunt
 * 
 */
class filter_algebra_testcase extends basic_testcase {

    protected $filter;

    protected function setUp() {
        parent::setUp();
        $this->filter = new filter_algebra(context_system::instance(), array());
    }

    function test_algebra_filter_no_algebra() {
        $this->assertEquals('<p>Look no algebra!</p>',
                $this->filter->filter('<p>Look no algebra!</p>'));
    }


    function test_algebra_filter_pluginfile() {
        $this->assertEquals('<img src="@@PLUGINFILE@@/photo.jpg">',
                $this->filter->filter('<img src="@@PLUGINFILE@@/photo.jpg">'));
    }

    function test_algebra_filter_draftfile() {
        $this->assertEquals('<img src="@@DRAFTFILE@@/photo.jpg">',
                $this->filter->filter('<img src="@@DRAFTFILE@@/photo.jpg">'));
    }

    function test_algebra_filter_unified_diff() {
        $diff = '
diff -u -r1.1 Worksheet.php
--- Worksheet.php   26 Sep 2003 04:18:02 -0000  1.1
+++ Worksheet.php   18 Nov 2009 03:58:50 -0000
@@ -1264,10 +1264,10 @@
         }

         // Strip the = or @ sign at the beginning of the formula string
-        if (ereg("^=",$formula)) {
+        if (preg_match("/^=/",$formula)) {
             $formula = preg_replace("/(^=)/","",$formula);
         }
-        elseif(ereg("^@",$formula)) {
+        elseif(preg_match("/^@/",$formula)) {
             $formula = preg_replace("/(^@)/","",$formula);
         }
         else {
';
        $this->assertEquals('<pre>' . $diff . '</pre>',
                $this->filter->filter('<pre>' . $diff . '</pre>'));
    }
}
