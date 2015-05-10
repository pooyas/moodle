<?php

/**
 * Print booktool log events definition
 *
 * @package    booktool
 * @subpackage print
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'book', 'action' => 'print', 'mtable' => 'book', 'field' => 'name'),
    array('module' => 'book', 'action' => 'print chapter', 'mtable' => 'book_chapters', 'field' => 'title')
);
