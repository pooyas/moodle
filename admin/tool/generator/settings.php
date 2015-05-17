<?php


/**
 * Admin settings.
 *
 * @package    admin_tool
 * @subpackage generator
 * @copyright  2015 Pooya Saeedi
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

