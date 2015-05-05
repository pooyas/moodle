<?php

/**
 * This file contains datbase upgrade code that is called from lib/db/upgrade.php,
 * and also check methods that can be used for pre-install checks via
 * admin/environment.php and lib/environmentlib.php.
 *
 * @package    core
 * @subpackage questionbank
 * @copyright  2007 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * In Lion, all random questions should have question.parent set to be the same
 * as question.id. One effect of MDL-5482 is that this will not be true for questions that
 * were backed up then restored. The probably does not cause many problems, except occasionally,
 * if the bogus question.parent happens to point to a multianswer question type, or when you
 * try to do a subsequent backup. Anyway, these question.parent values should be fixed, and
 * that is what this update does.
 */
function question_fix_random_question_parents() {
    global $CFG, $DB;
    $DB->execute("UPDATE {question} SET parent = id WHERE qtype = 'random' AND parent <> id");

    return true;
}
