<?php


/**
 * Strings for component 'qbehaviour_adaptive', language 'en'.
 *
 * @package    question_behaviour
 * @subpackage adaptive
 * @copyright  2015 Pooya Saeedi
 */

$string['disregardedwithoutpenalty'] = 'The submission was invalid, and has been disregarded without penalty.';
$string['gradingdetails'] = 'Marks for this submission: {$a->raw}/{$a->max}.';
$string['gradingdetailswithadjustment'] = 'Marks for this submission: {$a->raw}/{$a->max}. Accounting for previous tries, this gives <strong>{$a->cur}/{$a->max}</strong>.';
$string['gradingdetailswithadjustmentpenalty'] = 'Marks for this submission: {$a->raw}/{$a->max}. Accounting for previous tries, this gives <strong>{$a->cur}/{$a->max}</strong>. This submission attracted a penalty of {$a->penalty}.';
$string['gradingdetailswithadjustmenttotalpenalty'] = 'Marks for this submission: {$a->raw}/{$a->max}. Accounting for previous tries, this gives <strong>{$a->cur}/{$a->max}</strong>. This submission attracted a penalty of {$a->penalty}. Total penalties so far: {$a->totalpenalty}.';
$string['gradingdetailswithpenalty'] = 'Marks for this submission: {$a->raw}/{$a->max}. This submission attracted a penalty of {$a->penalty}.';
$string['gradingdetailswithtotalpenalty'] = 'Marks for this submission: {$a->raw}/{$a->max}. This submission attracted a penalty of {$a->penalty}. Total penalties so far: {$a->totalpenalty}.';
$string['notcomplete'] = 'Not complete';
$string['pluginname'] = 'Adaptive mode';

// Old strings these are currently only used in the unit tests, to verify that the new
// strings give the same results as the old strings.
$string['gradingdetailsadjustment'] = 'Accounting for previous tries, this gives <strong>{$a->cur}/{$a->max}</strong>.';
$string['gradingdetailspenalty'] = 'This submission attracted a penalty of {$a}.';
$string['gradingdetailspenaltytotal'] = 'Total penalties so far: {$a}.';
