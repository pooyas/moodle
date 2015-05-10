<?php

/**
 * Question behaviour type for interactive behaviour with count-back scoring behaviour.
 *
 * @package    qbehaviour
 * @subpackage interactivecountback
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../interactive/behaviourtype.php');


/**
 * Question behaviour type information for interactive behaviour with count-back scoring.
 *
 */
class qbehaviour_interactivecountback_type extends qbehaviour_interactive_type {
    public function is_archetypal() {
        return false;
    }
}
