<?php
/**
 * Print this server's public key and exit
 *
 * @package mnet
 * @copyright 2015 Pooya Saeedi
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once $CFG->dirroot.'/mnet/lib.php';

if ($CFG->mnet_dispatcher_mode === 'off') {
    print_error('mnetdisabled', 'mnet');
}

header("Content-type: text/plain; charset=utf-8");
$keypair = mnet_get_keypair();
echo $keypair['certificate'];
