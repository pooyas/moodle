<?php

/**
 * Book module log events definition
 *
 * @package    mod_book
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'book', 'action' => 'add', 'mtable' => 'book', 'field' => 'name'),
    array('module' => 'book', 'action' => 'update', 'mtable' => 'book', 'field' => 'name'),
    array('module' => 'book', 'action' => 'view', 'mtable' => 'book', 'field' => 'name'),
    array('module' => 'book', 'action' => 'add chapter', 'mtable' => 'book_chapters', 'field' => 'title'),
    array('module' => 'book', 'action' => 'update chapter', 'mtable'=> 'book_chapters', 'field' => 'title'),
    array('module' => 'book', 'action' => 'view chapter', 'mtable' => 'book_chapters', 'field' => 'title')
);
