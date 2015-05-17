<?php



/**
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
*/

function xmldb_feedback_install() {
    global $DB;

    /// Disable this module by default (because it's not technically part of Lion 2.0)
    $DB->set_field('modules', 'visible', 0, array('name'=>'feedback'));

}
