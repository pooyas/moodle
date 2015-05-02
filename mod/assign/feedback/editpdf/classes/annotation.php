<?php

/**
 * This file contains the annotation class for the assignfeedback_editpdf plugin
 *
 * @package   assignfeedback_editpdf
 * @copyright 2012 Davo Smith
 * 
 */

namespace assignfeedback_editpdf;

/**
 * This class adds and removes annotations from a page of a response.
 *
 * @package   assignfeedback_editpdf
 * @copyright 2012 Davo Smith
 * 
 */
class annotation {

    /** @var int unique id for this annotation */
    public $id = 0;

    /** @var int gradeid for this annotation */
    public $gradeid = 0;

    /** @var int page number for this annotation */
    public $pageno = 0;

    /** @var int starting location in pixels. Image resolution is 100 pixels per inch */
    public $x = 0;

    /** @var int ending location in pixels. Image resolution is 100 pixels per inch */
    public $endx = 0;

    /** @var int starting location in pixels. Image resolution is 100 pixels per inch */
    public $y = 0;

    /** @var int ending location in pixels. Image resolution is 100 pixels per inch */
    public $endy = 0;

    /** @var string path information for drawing the annotation. */
    public $path = '';

    /** @var string colour - One of red, yellow, green, blue, white */
    public $colour = 'yellow';

    /** @var string type - One of line, oval, rect, etc */
    public $type = 'line';

    /**
     * Convert a compatible stdClass into an instance of this class.
     * @param stdClass $record
     */
    public function __construct(\stdClass $record = null) {
        if ($record) {
            $intcols = array('endx', 'endy', 'x', 'y');
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
