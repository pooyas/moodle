<?php

/**
 * Short answer question definition class.
 *
 * @package    qtype
 * @subpackage shortanswer
 * @copyright  2009 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Represents a short answer question.
 *
 * @copyright  2009 The Open University
 * 
 */
class qtype_shortanswer_question extends question_graded_by_strategy
        implements question_response_answer_comparer {
    /** @var boolean whether answers should be graded case-sensitively. */
    public $usecase;
    /** @var array of question_answer. */
    public $answers = array();

    public function __construct() {
        parent::__construct(new question_first_matching_answer_grading_strategy($this));
    }

    public function get_expected_data() {
        return array('answer' => PARAM_RAW_TRIMMED);
    }

    public function summarise_response(array $response) {
        if (isset($response['answer'])) {
            return $response['answer'];
        } else {
            return null;
        }
    }

    public function is_complete_response(array $response) {
        return array_key_exists('answer', $response) &&
                ($response['answer'] || $response['answer'] === '0');
    }

    public function get_validation_error(array $response) {
        if ($this->is_gradable_response($response)) {
            return '';
        }
        return get_string('pleaseenterananswer', 'qtype_shortanswer');
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        return question_utils::arrays_same_at_key_missing_is_blank(
                $prevresponse, $newresponse, 'answer');
    }

    public function get_answers() {
        return $this->answers;
    }

    public function compare_response_with_answer(array $response, question_answer $answer) {
        if (!array_key_exists('answer', $response) || is_null($response['answer'])) {
            return false;
        }

        return self::compare_string_with_wildcard(
                $response['answer'], $answer->answer, !$this->usecase);
    }

    public static function compare_string_with_wildcard($string, $pattern, $ignorecase) {

        // Normalise any non-canonical UTF-8 characters before we start.
        $pattern = self::safe_normalize($pattern);
        $string = self::safe_normalize($string);

        // Break the string on non-escaped runs of asterisks.
        // ** is equivalent to *, but people were doing that, and with many *s it breaks preg.
        $bits = preg_split('/(?<!\\\\)\*+/', $pattern);

        // Escape regexp special characters in the bits.
        $escapedbits = array();
        foreach ($bits as $bit) {
            $escapedbits[] = preg_quote(str_replace('\*', '*', $bit), '|');
        }
        // Put it back together to make the regexp.
        $regexp = '|^' . implode('.*', $escapedbits) . '$|u';

        // Make the match insensitive if requested to.
        if ($ignorecase) {
            $regexp .= 'i';
        }

        return preg_match($regexp, trim($string));
    }

    /**
     * Normalise a UTf-8 string to FORM_C, avoiding the pitfalls in PHP's
     * normalizer_normalize function.
     * @param string $string the input string.
     * @return string the normalised string.
     */
    protected static function safe_normalize($string) {
        if ($string === '') {
            return '';
        }

        if (!function_exists('normalizer_normalize')) {
            return $string;
        }

        $normalised = normalizer_normalize($string, Normalizer::FORM_C);
        if (is_null($normalised)) {
            // An error occurred in normalizer_normalize, but we have no idea what.
            debugging('Failed to normalise string: ' . $string, DEBUG_DEVELOPER);
            return $string; // Return the original string, since it is the best we have.
        }

        return $normalised;
    }

    public function get_correct_response() {
        $response = parent::get_correct_response();
        if ($response) {
            $response['answer'] = $this->clean_response($response['answer']);
        }
        return $response;
    }

    public function clean_response($answer) {
        // Break the string on non-escaped asterisks.
        $bits = preg_split('/(?<!\\\\)\*/', $answer);

        // Unescape *s in the bits.
        $cleanbits = array();
        foreach ($bits as $bit) {
            $cleanbits[] = str_replace('\*', '*', $bit);
        }

        // Put it back together with spaces to look nice.
        return trim(implode(' ', $cleanbits));
    }

    public function check_file_access($qa, $options, $component, $filearea,
            $args, $forcedownload) {
        if ($component == 'question' && $filearea == 'answerfeedback') {
            $currentanswer = $qa->get_last_qt_var('answer');
            $answer = $this->get_matching_answer(array('answer' => $currentanswer));
            $answerid = reset($args); // Itemid is answer id.
            return $options->feedback && $answer && $answerid == $answer->id;

        } else if ($component == 'question' && $filearea == 'hint') {
            return $this->check_hint_file_access($qa, $options, $args);

        } else {
            return parent::check_file_access($qa, $options, $component, $filearea,
                    $args, $forcedownload);
        }
    }
}
