<?php

/**
 * Question behaviour for the old adaptive mode, with no penalties.
 *
 * @package    qbehaviour
 * @subpackage adaptivenopenalty
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../adaptive/behaviour.php');


/**
 * Question behaviour for adaptive mode, with no penalties.
 *
 * This is the old version of interactive mode, without penalties.
 *
 */
class qbehaviour_adaptivenopenalty extends qbehaviour_adaptive {
    protected function adjusted_fraction($fraction, $prevtries) {
        return $fraction;
    }
}
