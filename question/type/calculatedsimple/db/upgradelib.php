<?php

/**
 * Upgrade library code for the simple calculated question type.
 *
 * @package    qtype
 * @subpackage calculatedsimple
 * @copyright  2011 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/calculated/db/upgradelib.php');


/**
 * Class for converting attempt data for simple calculated questions when upgrading
 * attempts to the new question engine.
 *
 * This class is used by the code in question/engine/upgrade/upgradelib.php.
 *
 * @copyright  2011 The Open University
 * 
 */
class qtype_calculatedsimple_qe2_attempt_updater extends qtype_calculated_qe2_attempt_updater {
}
