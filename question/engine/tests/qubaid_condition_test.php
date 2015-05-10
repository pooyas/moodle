<?php

/**
 * This file contains tests for some of the code in ../datalib.php.
 *
 * @package    core
 * @subpackage questionengine
 * @category   phpunit 
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

global $CFG;
require_once(dirname(__FILE__) . '/../lib.php');


/**
 * Unit tests for qubaid_condition and subclasses.
 *
 */
class qubaid_condition_testcase extends advanced_testcase {

    protected function normalize_sql($sql, $params) {
        $newparams = array();
        preg_match_all('/(?<!:):([a-z][a-z0-9_]*)/', $sql, $named_matches);
        foreach($named_matches[1] as $param) {
            if (array_key_exists($param, $params)) {
                $newparams[] = $params[$param];
            }
        }
        $newsql = preg_replace('/(?<!:):[a-z][a-z0-9_]*/', '?', $sql);
        return array($newsql, $newparams);
    }

    protected function check_typical_question_attempts_query(
            qubaid_condition $qubaids, $expectedsql, $expectedparams) {
        $sql = "SELECT qa.id, qa.maxmark
            FROM {$qubaids->from_question_attempts('qa')}
            WHERE {$qubaids->where()} AND qa.slot = :slot";
        $params = $qubaids->from_where_params();
        $params['slot'] = 1;

        // NOTE: parameter names may change thanks to $DB->inorequaluniqueindex, normal comparison is very wrong!!
        list($sql, $params) = $this->normalize_sql($sql, $params);
        list($expectedsql, $expectedparams) = $this->normalize_sql($expectedsql, $expectedparams);

        $this->assertEquals($expectedsql, $sql);
        $this->assertEquals($expectedparams, $params);
    }

    protected function check_typical_in_query(qubaid_condition $qubaids,
            $expectedsql, $expectedparams) {
        $sql = "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid {$qubaids->usage_id_in()}";

        // NOTE: parameter names may change thanks to $DB->inorequaluniqueindex, normal comparison is very wrong!!
        list($sql, $params) = $this->normalize_sql($sql, $qubaids->usage_id_in_params());
        list($expectedsql, $expectedparams) = $this->normalize_sql($expectedsql, $expectedparams);

        $this->assertEquals($expectedsql, $sql);
        $this->assertEquals($expectedparams, $params);
    }

    public function test_qubaid_list_one_join() {
        $qubaids = new qubaid_list(array(1));
        $this->check_typical_question_attempts_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid = :qubaid1 AND qa.slot = :slot",
            array('qubaid1' => 1, 'slot' => 1));
    }

    public function test_qubaid_list_several_join() {
        $qubaids = new qubaid_list(array(1, 3, 7));
        $this->check_typical_question_attempts_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid IN (:qubaid2,:qubaid3,:qubaid4) AND qa.slot = :slot",
            array('qubaid2' => 1, 'qubaid3' => 3, 'qubaid4' => 7, 'slot' => 1));
    }

    public function test_qubaid_join() {
        $qubaids = new qubaid_join("{other_table} ot", 'ot.usageid', 'ot.id = 1');

        $this->check_typical_question_attempts_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {other_table} ot
                JOIN {question_attempts} qa ON qa.questionusageid = ot.usageid
            WHERE ot.id = 1 AND qa.slot = :slot", array('slot' => 1));
    }

    public function test_qubaid_join_no_where_join() {
        $qubaids = new qubaid_join("{other_table} ot", 'ot.usageid');

        $this->check_typical_question_attempts_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {other_table} ot
                JOIN {question_attempts} qa ON qa.questionusageid = ot.usageid
            WHERE 1 = 1 AND qa.slot = :slot", array('slot' => 1));
    }

    public function test_qubaid_list_one_in() {
        global $CFG;
        $qubaids = new qubaid_list(array(1));
        $this->check_typical_in_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid = :qubaid5", array('qubaid5' => 1));
    }

    public function test_qubaid_list_several_in() {
        global $CFG;
        $qubaids = new qubaid_list(array(1, 2, 3));
        $this->check_typical_in_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid IN (:qubaid6,:qubaid7,:qubaid8)",
                array('qubaid6' => 1, 'qubaid7' => 2, 'qubaid8' => 3));
    }

    public function test_qubaid_join_in() {
        global $CFG;
        $qubaids = new qubaid_join("{other_table} ot", 'ot.usageid', 'ot.id = 1');

        $this->check_typical_in_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid IN (SELECT ot.usageid FROM {other_table} ot WHERE ot.id = 1)",
                array());
    }

    public function test_qubaid_join_no_where_in() {
        global $CFG;
        $qubaids = new qubaid_join("{other_table} ot", 'ot.usageid');

        $this->check_typical_in_query($qubaids,
                "SELECT qa.id, qa.maxmark
            FROM {question_attempts} qa
            WHERE qa.questionusageid IN (SELECT ot.usageid FROM {other_table} ot WHERE 1 = 1)",
                array());
    }
}
