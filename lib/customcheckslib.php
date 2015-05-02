<?php

/**
 * This is a place to put custom environment checks, if there is not a better place.
 *
 * This library contains a collection of functions able to perform
 * some custom checks executed by environmental tests (automatically
 * executed on install & upgrade and under petition in the admin block).
 *
 * Any function in this library gets a environment_results object passed in.
 * It must return:
 * - null: if the test isn't relevant and must not be showed (ignored)
 * - the environment_results object that was passed in, with the status set to:
 *     - true: if passed
 *     - false: if failed
 *
 * @package    core
 * @subpackage admin
 * @copyright  (C) 2001-3001 Eloy Lafuente (stronk7) {@link http://contiento.com}
 * 
 */

defined('LION_INTERNAL') || die();
