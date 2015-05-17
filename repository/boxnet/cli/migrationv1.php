<?php


/**
 * Box.net migration CLI script.
 *
 * @package    repository
 * @subpackage boxnet
 * @copyright  2015 Pooya Saeedi
 */

define('CLI_SCRIPT', true);
require(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->dirroot . '/repository/boxnet/locallib.php');

// Now get cli options.
list($options, $unrecognized) = cli_get_params(array(
    'help' => false,
    'confirm' => '',
));

if ($unrecognized) {
    $unrecognized = implode("\n  ", $unrecognized);
    cli_error(get_string('cliunknowoption', 'admin', $unrecognized));
}

$help =
"Box.net APIv1 migration tool.

Options:
-h, --help                 Print out this help
--confirm                  Proceed with the migration

Example:
\$ sudo -u www-data /usr/bin/php admin/tool/boxnetv1migrationtool/cli/migrate.php --confirm=1
";

if ($options['help'] || empty($options['confirm'])) {
    echo $help;
    die();
}

if ($options['confirm']) {
    mtrace("Box.net migration running...");
    repository_boxnet_migrate_references_from_apiv1();
}

