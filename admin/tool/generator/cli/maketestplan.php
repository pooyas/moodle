<?php


/**
 * CLI interface for creating a test plan
 *
 * @package    admin_tool
 * @subpackage generator
 * @copyright  2015 Pooya Saeedi
 */

define('CLI_SCRIPT', true);
define('NO_OUTPUT_BUFFERING', true);

require(dirname(__FILE__) . '/../../../../config.php');
require_once($CFG->libdir. '/clilib.php');

// CLI options.
list($options, $unrecognized) = cli_get_params(
    array(
        'help' => false,
        'shortname' => false,
        'size' => false,
        'bypasscheck' => false,
        'updateuserspassword' => false
    ),
    array(
        'h' => 'help'
    )
);

$testplansizes = '* ' . implode(PHP_EOL . '* ', tool_generator_testplan_backend::get_size_choices());

// Display help.
if (!empty($options['help']) || empty($options['shortname']) || empty($options['size'])) {

    echo get_string('testplanexplanation', 'tool_generator', tool_generator_testplan_backend::get_repourl()) .
"Options:
-h, --help              Print out this help
--shortname             Shortname of the test plan's target course (required)
--size                  Size of the test plan to create XS, S, M, L, XL, or XXL (required)
--bypasscheck           Bypasses the developer-mode check (be careful!)
--updateuserspassword   Updates the target course users password according to \$CFG->tool_generator_users_password

$testplansizes

Consider that, the server resources you will need to run the test plan will be higher as the test plan size is higher.

Example from Lion root directory:
\$ sudo -u www-data /usr/bin/php admin/tool/generator/cli/maketestplan.php --shortname=\"testcourse_12\" --size=S
";
    // Exit with error unless we're showing this because they asked for it.
    exit(empty($options['help']) ? 1 : 0);
}

// Check debugging is set to developer level.
if (empty($options['bypasscheck']) && !$CFG->debugdeveloper) {
    cli_error(get_string('error_notdebugging', 'tool_generator'));
}

// Get options.
$shortname = $options['shortname'];
$sizename = $options['size'];

// Check size.
try {
    $size = tool_generator_testplan_backend::size_for_name($sizename);
} catch (coding_exception $e) {
    cli_error("Error: Invalid size ($sizename). Use --help for help.");
}

// Check selected course.
if ($errors = tool_generator_testplan_backend::has_selected_course_any_problem($shortname, $size)) {
    // Showing the first reported problem.
    cli_error("Error: " . reset($errors));
}

// Checking if test users password is set.
if (empty($CFG->tool_generator_users_password) || is_bool($CFG->tool_generator_users_password)) {
    cli_error("Error: " . get_string('error_nouserspassword', 'tool_generator'));
}

// Switch to admin user account.
\core\session\manager::set_user(get_admin());

// Create files.
$courseid = $DB->get_field('course', 'id', array('shortname' => $shortname));
$usersfile = tool_generator_testplan_backend::create_users_file($courseid, !empty($options['updateuserspassword']));
$testplanfile = tool_generator_testplan_backend::create_testplan_file($courseid, $size);

// One file path per line so other CLI scripts can easily parse the output.
echo lion_url::make_pluginfile_url(
        $testplanfile->get_contextid(),
        $testplanfile->get_component(),
        $testplanfile->get_filearea(),
        $testplanfile->get_itemid(),
        $testplanfile->get_filepath(),
        $testplanfile->get_filename()
    ) .
    PHP_EOL .
    lion_url::make_pluginfile_url(
        $usersfile->get_contextid(),
        $usersfile->get_component(),
        $usersfile->get_filearea(),
        $usersfile->get_itemid(),
        $usersfile->get_filepath(),
        $usersfile->get_filename()
    ) .
    PHP_EOL;
