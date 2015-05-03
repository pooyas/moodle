<?php

/**
 * Class for storing calculated sub question statistics and intermediate calculation values.
 *
 * @package    core_question
 * @copyright  2015 Pooya Saeedi
 * @author     James Pratt me@jamiep.org
 * 
 */

namespace core_question\statistics\questions;
defined('LION_INTERNAL') || die();

/**
 * A class to store calculated stats for a sub question.
 *
 * @package    core_question
 * @copyright  2015 Pooya Saeedi
 * @author     James Pratt me@jamiep.org
 * 
 */
class calculated_for_subquestion extends calculated {
    public $subquestion = true;

    /**
     * @var array What slots is this sub question used in?
     */
    public $usedin = array();

    /**
     * @var bool Have the slots this sub question has been used in got different grades?
     */
    public $differentweights = false;

    public $negcovar = 0;

    /**
     * @var int only set immediately before display in the table. The order of display in the table.
     */
    public $subqdisplayorder;

    /**
     * Constructor.
     *
     * @param object|null $step the step data for the step that this sub-question was first encountered in.
     * @param int|null $variant the variant no
     */
    public function __construct($step = null, $variant = null) {
        if ($step !== null) {
            $this->questionid = $step->questionid;
            $this->maxmark = $step->maxmark;
        }
        $this->variant = $variant;
    }
}
