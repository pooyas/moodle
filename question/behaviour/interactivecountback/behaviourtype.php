<?php

/**
 * Question behaviour type for interactive behaviour with count-back scoring behaviour.
 *
 * @package    qbehaviour_interactivecountback
 * @copyright  2012 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../interactive/behaviourtype.php');


/**
 * Question behaviour type information for interactive behaviour with count-back scoring.
 *
 * @copyright  2012 The Open University
 * 
 */
class qbehaviour_interactivecountback_type extends qbehaviour_interactive_type {
    public function is_archetypal() {
        return false;
    }
}
