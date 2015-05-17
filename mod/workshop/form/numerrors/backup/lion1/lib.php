<?php



/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->libdir.'/gradelib.php'); // grade_floatval() called here

/**
 * Conversion handler for the numerrors grading strategy data
 */
class lion1_workshopform_numerrors_handler extends lion1_workshopform_handler {

    /** @var array */
    protected $mappings = array();

    /** @var array */
    protected $dimensions = array();

    /**
     * New workshop instance is being processed
     */
    public function on_elements_start() {
        $this->mappings = array();
        $this->dimensions = array();
    }

    /**
     * Converts <ELEMENT> into <workshopform_numerrors_dimension> and stores it for later writing
     *
     * @param array $data legacy element data
     * @param array $raw raw element data
     *
     * @return array to be written to workshop.xml
     */
    public function process_legacy_element(array $data, array $raw) {

        $workshop = $this->parenthandler->get_current_workshop();

        $mapping = array();
        $mapping['id'] = $data['id'];
        $mapping['nonegative'] = $data['elementno'];
        if ($workshop['grade'] == 0 or $data['maxscore'] == 0) {
            $mapping['grade'] = 0;
        } else {
            $mapping['grade'] = grade_floatval($data['maxscore'] / $workshop['grade'] * 100);
        }
        $this->mappings[] = $mapping;

        $converted = null;

        if (trim($data['description']) and $data['description'] <> '@@ GRADE_MAPPING_ELEMENT @@') {
            // prepare a fake record and re-use the upgrade logic
            $fakerecord = (object)$data;
            $converted = (array)workshopform_numerrors_upgrade_element($fakerecord, 12345678);
            unset($converted['workshopid']);

            $converted['id'] = $data['id'];
            $this->dimensions[] = $converted;
        }

        return $converted;
    }

    /**
     * Writes gathered mappings and dimensions
     */
    public function on_elements_end() {

        foreach ($this->mappings as $mapping) {
            $this->write_xml('workshopform_numerrors_map', $mapping, array('/workshopform_numerrors_map/id'));
        }

        foreach ($this->dimensions as $dimension) {
            $this->write_xml('workshopform_numerrors_dimension', $dimension, array('/workshopform_numerrors_dimension/id'));
        }
    }
}

/**
 * Transforms a given record from workshop_elements_old into an object to be saved into workshopform_numerrors
 *
 * @param stdClass $old legacy record from workshop_elements_old
 * @param int $newworkshopid id of the new workshop instance that replaced the previous one
 * @return stdclass to be saved in workshopform_numerrors
 */
function workshopform_numerrors_upgrade_element(stdclass $old, $newworkshopid) {
    $new = new stdclass();
    $new->workshopid = $newworkshopid;
    $new->sort = $old->elementno;
    $new->description = $old->description;
    $new->descriptionformat = FORMAT_HTML;
    $new->grade0 = get_string('grade0default', 'workshopform_numerrors');
    $new->grade1 = get_string('grade1default', 'workshopform_numerrors');
    // calculate new weight of the element. Negative weights are not supported any more and
    // are replaced with weight = 0. Legacy workshop did not store the raw weight but the index
    // in the array of weights (see $WORKSHOP_EWEIGHTS in workshop 1.x)
    // workshop 2.0 uses integer weights only (0-16) so all previous weights are multiplied by 4.
    switch ($old->weight) {
        case 8: $new->weight = 1; break;
        case 9: $new->weight = 2; break;
        case 10: $new->weight = 3; break;
        case 11: $new->weight = 4; break;
        case 12: $new->weight = 6; break;
        case 13: $new->weight = 8; break;
        case 14: $new->weight = 16; break;
        default: $new->weight = 0;
    }
    return $new;
}
