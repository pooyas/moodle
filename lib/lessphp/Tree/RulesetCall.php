<?php

/**
 * RulesetCall
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
class Less_Tree_RulesetCall extends Less_Tree{

	public $variable;
	public $type = "RulesetCall";

	function __construct($variable){
		$this->variable = $variable;
	}

	function accept($visitor) {}

	function compile( $env ){
		$variable = new Less_Tree_Variable($this->variable);
		$detachedRuleset = $variable->compile($env);
		return $detachedRuleset->callEval($env);
	}
}

