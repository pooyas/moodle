<?php

/**
 * @package    backup
 * @subpackage cc
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') or die('Direct access to this script is forbidden.');

// GENERAL PARAMETERS ************************************************************************************************* //
define('ROOT_DEEP', 2);

// PACKAGES FORMATS *************************************************************************************************** //
define('FORMAT_UNKNOWN', 'NA');
define('FORMAT_COMMON_CARTRIDGE', 'CC');
define('FORMAT_BLACK_BOARD', 'BB');

// FORMATS NAMESPACES ************************************************************************************************* //
define('NS_COMMON_CARTRIDGE', 'http://www.imsglobal.org/xsd/imscc/imscp_v1p1');
define('NS_BLACK_BOARD', 'http://www.blackboard.com/content-packaging');

// SHEET FILES ******************************************************************************************************** //
define('SHEET_BASE', 'cc/sheets/base.xml');
define('SHEET_INFO_DETAILS_MOD', 'cc/sheets/info_details_mod.xml');
define('SHEET_INFO_DETAILS_MOD_INSTANCE', 'cc/sheets/info_details_mod_instance.xml');
define('SHEET_COURSE_BLOCKS_BLOCK', 'cc/sheets/course_blocks_block.xml');
define('SHEET_COURSE_HEADER', 'cc/sheets/course_header.xml');
define('SHEET_COURSE_SECTIONS_SECTION', 'cc/sheets/course_sections_section.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD', 'cc/sheets/course_sections_section_mods_mod.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_FORUM', 'cc/sheets/course_modules_mod_forum.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_LABEL', 'cc/sheets/course_modules_mod_label.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_RESOURCE', 'cc/sheets/course_modules_mod_resource.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_QUIZ', 'cc/sheets/course_modules_mod_quiz.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_QUIZ_QUESTION_INSTANCE', 'cc/sheets/course_modules_mod_quiz_question_instance.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_QUIZ_FEEDBACK', 'cc/sheets/course_modules_mod_quiz_feedback.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES', 'cc/sheets/course_question_categories.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY', 'cc/sheets/course_question_categories_question_category.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY_QUESTION', 'cc/sheets/course_question_categories_question_category_question.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY_QUESTION_MULTIPLE_CHOICE', 'cc/sheets/course_question_categories_question_category_question_multiple_choice.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY_QUESTION_TRUE_FALSE', 'cc/sheets/course_question_categories_question_category_question_true_false.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY_QUESTION_EESAY', 'cc/sheets/course_question_categories_question_category_question_eesay.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY_QUESTION_SHORTANSWER', 'cc/sheets/course_question_categories_question_category_question_shortanswer.xml');
define('SHEET_COURSE_QUESTION_CATEGORIES_QUESTION_CATEGORY_QUESTION_ANSWER', 'cc/sheets/course_question_categories_question_category_question_answer.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_BASICLTI', 'cc/sheets/course_modules_mod_basiclti.xml');
define('SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_LTI', 'cc/sheets/course_modules_mod_lti.xml');

// CC RESOURCES TYPE ************************************************************************************************** //
define('CC_TYPE_FORUM', 'imsdt_xmlv1p0');
define('CC_TYPE_QUIZ', 'imsqti_xmlv1p2/imscc_xmlv1p0/assessment');
define('CC_TYPE_QUESTION_BANK', 'imsqti_xmlv1p2/imscc_xmlv1p0/question-bank');
define('CC_TYPE_WEBLINK', 'imswl_xmlv1p0');
define('CC_TYPE_WEBCONTENT', 'webcontent');
define('CC_TYPE_ASSOCIATED_CONTENT', 'associatedcontent/imscc_xmlv1p0/learning-application-resource');
define('CC_TYPE_EMPTY', '');

// LION RESOURCES TYPE ********************************************************************************************** //
define('LION_TYPE_FORUM', 'forum');
define('LION_TYPE_QUIZ', 'quiz');
define('LION_TYPE_QUESTION_BANK', 'question_bank');
define('LION_TYPE_RESOURCE', 'resource');
define('LION_TYPE_LABEL', 'label');
define('LION_TYPE_BASICLTI', 'basiclti');
define('LION_TYPE_LTI', 'lti');

// UNKNOWN TYPE ******************************************************************************************************* //
define('TYPE_UNKNOWN', '[UNKNOWN]');

// CC QUESTIONS TYPES ************************************************************************************************* //
define('CC_QUIZ_MULTIPLE_CHOICE', 'cc.multiple_choice.v0p1');
define('CC_QUIZ_TRUE_FALSE', 'cc.true_false.v0p1');
define('CC_QUIZ_FIB', 'cc.fib.v0p1');
define('CC_QUIZ_MULTIPLE_RESPONSE', 'cc.multiple_response.v0p1');
define('CC_QUIZ_PATTERN_MACHT', 'cc.pattern_match.v0p1');
define('CC_QUIZ_ESSAY', 'cc.essay.v0p1');

//LION QUESTIONS TYPES ********************************************************************************************** //
define('LION_QUIZ_MULTIPLE_CHOICE', 'multichoice');
define('LION_QUIZ_TRUE_FALSE', 'truefalse');
define('LION_QUIZ_MULTIANSWER', 'multianswer');
define('LION_QUIZ_MULTIPLE_RESPONSE', 'multichoice');
define('LION_QUIZ_MACHT', 'match');
define('LION_QUIZ_ESSAY', 'essay');
define('LION_QUIZ_SHORTANSWER', 'shortanswer');
