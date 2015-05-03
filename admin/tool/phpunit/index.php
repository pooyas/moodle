<?php

/**
 * PHPUnit info
 *
 * @package    tool
 * @subpackage phpunit
 * @copyright  2015 Pooya Saeedi 
 * 
 */

require(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toolphpunit');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'tool_phpunit'));
echo $OUTPUT->box_start();

$info = file_get_contents("$CFG->libdir/phpunit/readme.md");
echo markdown_to_html($info);

echo $OUTPUT->box_end();
echo $OUTPUT->footer();
