<?php

/**
 * Link to InnoDB conversion tool
 *
 * @package    tool
 * @subpackage innodb
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('unsupported', new admin_externalpage('toolinnodb', 'Convert to InnoDB', $CFG->wwwroot.'/'.$CFG->admin.'/tool/innodb/index.php', 'lion/site:config', true));
}
