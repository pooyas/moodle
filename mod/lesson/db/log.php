<?php


/**
 * Definition of log events
 *
 * @package    mod_lesson
 * @category   log
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module'=>'lesson', 'action'=>'start', 'mtable'=>'lesson', 'field'=>'name'),
    array('module'=>'lesson', 'action'=>'end', 'mtable'=>'lesson', 'field'=>'name'),
    array('module'=>'lesson', 'action'=>'view', 'mtable'=>'lesson_pages', 'field'=>'title'),
);