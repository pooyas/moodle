<?php


/**
 * This file contains the definition for the library class for edit PDF renderer.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * A custom renderer class that extends the plugin_renderer_base and is used by the editpdf feedback plugin.
 *
 */
class assignfeedback_editpdf_widget implements renderable {

    /** @var int $assignment - Assignment instance id */
    public $assignment = 0;
    /** @var int $userid - The user id we are grading */
    public $userid = 0;
    /** @var mixed $attemptnumber - The attempt number we are grading */
    public $attemptnumber = 0;
    /** @var lion_url $downloadurl */
    public $downloadurl = null;
    /** @var string $downloadfilename */
    public $downloadfilename = null;
    /** @var string[] $stampfiles */
    public $stampfiles = array();
    /** @var bool $readonly */
    public $readonly = true;
    /** @var integer $pagetotal */
    public $pagetotal = 0;

    /**
     * Constructor
     * @param int $assignment - Assignment instance id
     * @param int $userid - The user id we are grading
     * @param int $attemptnumber - The attempt number we are grading
     * @param lion_url $downloadurl - A url to download the current generated pdf.
     * @param string $downloadfilename - Name of the generated pdf.
     * @param string[] $stampfiles - The file names of the stamps.
     * @param bool $readonly - Show the readonly interface (no tools).
     * @param integer $pagetotal - The total number of pages.
     */
    public function __construct($assignment, $userid, $attemptnumber, $downloadurl,
                                $downloadfilename, $stampfiles, $readonly, $pagetotal) {
        $this->assignment = $assignment;
        $this->userid = $userid;
        $this->attemptnumber = $attemptnumber;
        $this->downloadurl = $downloadurl;
        $this->downloadfilename = $downloadfilename;
        $this->stampfiles = $stampfiles;
        $this->readonly = $readonly;
        $this->pagetotal = $pagetotal;
    }
}
