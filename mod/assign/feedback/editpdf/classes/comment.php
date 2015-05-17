<?php


/**
 * This file contains the comment class for the assignfeedback_editpdf plugin
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace assignfeedback_editpdf;

/**
 * This class represents a comment box on a page of feedback.
 */
class comment {

    /** @var int unique id for this annotation */
    public $id = 0;

    /** @var int gradeid for this annotation */
    public $gradeid = 0;

    /** @var int page number for this annotation */
    public $pageno = 0;

    /** @var int starting location in pixels. Image resolution is 100 pixels per inch */
    public $x = 0;

    /** @var int starting location in pixels. Image resolution is 100 pixels per inch */
    public $y = 0;

    /** @var int width of the comment box */
    public $width = 120;

    /** @var string The comment text. */
    public $rawtext = '';

    /** @var string colour - One of red, yellow, green, blue, white */
    public $colour = 'yellow';

    /**
     * Convert a compatible stdClass into an instance of a comment.
     * @param \stdClass $record
     */
    public function __construct(\stdClass $record = null) {
        if ($record) {
            $intcols = array('width', 'x', 'y');
            foreach ($this as $key => $value) {
                if (isset($record->$key)) {
                    if (in_array($key, $intcols)) {
                        $this->$key = intval($record->$key);
                    } else {
                        $this->$key = $record->$key;
                    }
                }
            }
        }
    }
}
