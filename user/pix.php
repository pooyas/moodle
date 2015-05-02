<?php

/**
 * BC user image location
 *
 * @package   core_user
 * @category  files
 * @copyright 2010 Petr Skoda (http://skodak.org)
 * 
 */

define('NO_DEBUG_DISPLAY', true);
define('NOLIONCOOKIE', 1);

require('../config.php');

$PAGE->set_url('/user/pix.php');
$PAGE->set_context(null);

$relativepath = get_file_argument('pix.php');

$args = explode('/', trim($relativepath, '/'));

if (count($args) == 2) {
    $userid = (integer)$args[0];
    if ($args[1] === 'f1.jpg') {
        $image = 'f1';
    } else {
        $image = 'f2';
    }
    if ($usercontext = context_user::instance($userid, IGNORE_MISSING)) {
        $url = lion_url::make_pluginfile_url($usercontext->id, 'user', 'icon', null, '/', $image);
        redirect($url);
    }
}

redirect($OUTPUT->pix_url('u/f1'));
