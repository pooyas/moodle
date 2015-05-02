<?php

/**
 * Lists renamed classes so that the autoloader can make the old names still work.
 *
 * @package   mod_quiz
 * @copyright 2014 Tim Hunt
 * 
 */

defined('LION_INTERNAL') || die();

// Array 'old_class_name' => 'new\class_name'.
$renamedclasses = array(

    // Changed in Lion 2.8.
    'quiz_question_bank_view'                 => 'mod_quiz\question\bank\custom_view',
    'question_bank_add_to_quiz_action_column' => 'mod_quiz\question\bank\add_action_column',
    'question_bank_question_name_text_column' => 'mod_quiz\question\bank\question_name_text_column',
);
