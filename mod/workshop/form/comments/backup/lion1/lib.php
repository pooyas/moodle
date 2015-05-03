<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    workshopform_comments
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Conversion handler for the comments grading strategy data
 */
class lion1_workshopform_comments_handler extends lion1_workshopform_handler {

    /**
     * Converts <ELEMENT> into <workshopform_comments_dimension>
     *
     * @param array $data legacy element data
     * @param array $raw raw element data
     *
     * @return array converted
     */
    public function process_legacy_element(array $data, array $raw) {
        // prepare a fake record and re-use the upgrade logic
        $fakerecord = (object)$data;
        $converted = (array)workshopform_comments_upgrade_element($fakerecord, 12345678);
        unset($converted['workshopid']);

        $converted['id'] = $data['id'];
        $this->write_xml('workshopform_comments_dimension', $converted, array('/workshopform_comments_dimension/id'));

        return $converted;
    }
}

/**
 * Transforms a given record from workshop_elements_old into an object to be saved into workshopform_comments
 *
 * @param stdClass $old legacy record from workshop_elements_old
 * @param int $newworkshopid id of the new workshop instance that replaced the previous one
 * @return stdclass to be saved in workshopform_comments
 */
function workshopform_comments_upgrade_element(stdclass $old, $newworkshopid) {
    $new                    = new stdclass();
    $new->workshopid        = $newworkshopid;
    $new->sort              = $old->elementno;
    $new->description       = $old->description;
    $new->descriptionformat = FORMAT_HTML;
    return $new;
}
