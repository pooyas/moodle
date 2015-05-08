<?php

/**
 * Question behaviour type for immediate feedback with CBM behaviour.
 *
 * @package    qbehaviour_adaptive
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../deferredcbm/behaviourtype.php');


/**
 * Question behaviour type information for immediate feedback with CBM.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qbehaviour_immediatecbm_type extends qbehaviour_deferredcbm_type {

    public function get_unused_display_options() {
        return array();
    }
}
