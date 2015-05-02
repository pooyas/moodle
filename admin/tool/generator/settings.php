<?php

/**
 * Admin settings.
 *
 * @package tool_generator
 * @copyright 2013 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('development', new admin_externalpage('toolgeneratorcourse',
            get_string('maketestcourse', 'tool_generator'),
            $CFG->wwwroot . '/' . $CFG->admin . '/tool/generator/maketestcourse.php'));

    $ADMIN->add('development', new admin_externalpage('toolgeneratortestplan',
            get_string('maketestplan', 'tool_generator'),
            $CFG->wwwroot . '/' . $CFG->admin . '/tool/generator/maketestplan.php'));
}

