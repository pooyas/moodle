<?php


/**
 * Definition of log events for the quiz module.
 *
 * @category   log
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'quiz', 'action'=>'add', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'update', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'view', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'report', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'attempt', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'submit', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'review', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'editquestions', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'preview', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'start attempt', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'close attempt', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'continue attempt', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'edit override', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'delete override', 'mtable'=>'quiz', 'field'=>'name'),
    array('module'=>'quiz', 'action'=>'view summary', 'mtable'=>'quiz', 'field'=>'name'),
);