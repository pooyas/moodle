<?php


/**
 * This file is the landing point for returning to lion after authenticating at mahara
 *
 * @package    portfolio
 * @subpackage mahara
 * @copyright 2015 Pooya Saeedi
 * 
 */
require_once(dirname(dirname(dirname(__FILE__))). '/config.php');

if (empty($CFG->enableportfolios)) {
    print_error('disabled', 'portfolio');
}

require_once($CFG->libdir . '/portfoliolib.php');
require_once($CFG->libdir . '/portfolio/plugin.php');
require_once($CFG->libdir . '/portfolio/exporter.php');
require_once($CFG->dirroot . '/mnet/lib.php');

require_login();

$id     = required_param('id', PARAM_INT);              // id of current export
$landed = optional_param('landed', false, PARAM_BOOL);  // this is the parameter we get back after we've jumped to mahara

if (!$landed) {
    $exporter = portfolio_exporter::rewaken_object($id);
    $exporter->verify_rewaken();

    $mnetauth = get_auth_plugin('mnet');
    if (!$url = $mnetauth->start_jump_session($exporter->get('instance')->get_config('mnethostid'), '/portfolio/mahara/preconfig.php?landed=1&id=' . $id, true)) {
        throw new porfolio_exception('failedtojump', 'portfolio_mahara');
    }
    redirect($url);
} else {
    // now we have the sso session set up, start sending intent stuff and then redirect back to portfolio/add.php when we're done
    $exporter = portfolio_exporter::rewaken_object($id);
    $exporter->verify_rewaken();

    $exporter->get('instance')->send_intent();
    redirect($CFG->wwwroot . '/portfolio/add.php?postcontrol=1&sesskey=' . sesskey() . '&id=' . $id);
}

