<?php


/**
 * LTI upgrade script.
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

/**
 * Update any custom parameter settings separated by semicolons.
 */
function mod_lti_upgrade_custom_separator() {
    global $DB;

    // Initialise parameter array.
    $params = array('semicolon' => ';', 'likecr' => "%\r%", 'likelf' => "%\n%", 'lf' => "\n");

    // Initialise NOT LIKE clauses to check for CR and LF characters.
    $notlikecr = $DB->sql_like('value', ':likecr', true, true, true);
    $notlikelf = $DB->sql_like('value', ':likelf', true, true, true);

    // Update any instances in the lti_types_config table.
    $sql = 'UPDATE {lti_types_config} ' .
           'SET value = REPLACE(value, :semicolon, :lf) ' .
           'WHERE (name = \'customparameters\') AND (' . $notlikecr . ') AND (' . $notlikelf . ')';
    $DB->execute($sql, $params);

    // Initialise NOT LIKE clauses to check for CR and LF characters.
    $notlikecr = $DB->sql_like('instructorcustomparameters', ':likecr', true, true, true);
    $notlikelf = $DB->sql_like('instructorcustomparameters', ':likelf', true, true, true);

    // Update any instances in the lti table.
    $sql = 'UPDATE {lti} ' .
           'SET instructorcustomparameters = REPLACE(instructorcustomparameters, :semicolon, :lf) ' .
           'WHERE (instructorcustomparameters IS NOT NULL) AND (' . $notlikecr . ') AND (' . $notlikelf . ')';
    $DB->execute($sql, $params);
}
