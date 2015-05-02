<?php

/**
 * Strings for component 'mimetypes', language 'en', branch 'LION_20_STABLE'
 *
 * Strings are used to display human-readable name of mimetype. Some mimetypes share the same
 * string. The following attributes are passed in the parameter when processing the string:
 *   $a->ext - filename extension in lower case
 *   $a->EXT - filename extension, capitalized
 *   $a->Ext - filename extension with first capital letter
 *   $a->mimetype - file mimetype
 *   $a->mimetype1 - first chunk of mimetype (before /)
 *   $a->mimetype2 - second chunk of mimetype (after /)
 *   $a->Mimetype, $a->MIMETYPE, $a->Mimetype1, $a->Mimetype2, $a->MIMETYPE1, $a->MIMETYPE2
 *      - the same with capitalized first/all letters
 *
 * @see       get_mimetypes_array()
 * @see       get_mimetype_description()
 * @package   core
 * @copyright 1999 onwards Martin Dougiamas  {@link http://lion.com}
 * 
 */

$string['application/msword'] = 'Word document';
$string['application/pdf'] = 'PDF document';
$string['application/vnd.lion.backup'] = 'Lion backup';
$string['application/vnd.ms-excel'] = 'Excel spreadsheet';
$string['application/vnd.ms-powerpoint'] = 'Powerpoint presentation';
$string['application/vnd.openxmlformats-officedocument.presentationml.presentation'] = 'Powerpoint presentation';
$string['application/vnd.openxmlformats-officedocument.presentationml.slideshow'] = 'Powerpoint slideshow';
$string['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'] = 'Excel spreadsheet';
$string['application/vnd.openxmlformats-officedocument.spreadsheetml.template'] = 'Excel template';
$string['application/vnd.openxmlformats-officedocument.wordprocessingml.document'] = 'Word document';
$string['application/epub_zip'] = 'EPUB ebook';
$string['archive'] = 'Archive ({$a->EXT})';
$string['audio'] = 'Audio file ({$a->EXT})';
$string['default'] = '{$a->mimetype}';
$string['document/unknown'] = 'File';
$string['image'] = 'Image ({$a->MIMETYPE2})';
$string['text/html'] = 'HTML document';
$string['text/plain'] = 'Text file';
$string['text/rtf'] = 'RTF document';
