<?php

/**
 * Print booktool log events definition
 *
 * @package    booktool_print
 * @copyright  2012 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

defined('LION_INTERNAL') || die();

$logs = array(
    array('module' => 'book', 'action' => 'print', 'mtable' => 'book', 'field' => 'name'),
    array('module' => 'book', 'action' => 'print chapter', 'mtable' => 'book_chapters', 'field' => 'title')
);
