<?php


/**
 * @package    lioncore
 * @subpackage backup-structure
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 *
 * TODO: Finish phpdocs
 */

/**
 * Instantiable class representing one attribute atom (name/value) piece of information on backup
 */
class backup_attribute extends base_attribute implements processable, annotable {

    protected $annotationitem; // To store the item this element will be responsible to annotate

    public function process($processor) {
        if (!$processor instanceof base_processor) { // No correct processor, throw exception
            throw new base_element_struct_exception('incorrect_processor');
        }
        $processor->process_attribute($this);
    }

    public function set_annotation_item($itemname) {
        if (!empty($this->annotationitem)) {
            $a = new stdclass();
            $a->attribute = $this->get_name();
            $a->annotating= $this->annotationitem;
            throw new base_element_struct_exception('attribute_already_used_for_annotation', $a);
        }
        $this->annotationitem = $itemname;
    }

    public function annotate($backupid) {
        if (empty($this->annotationitem)) { // We aren't annotating this item
            return;
        }
        if (!$this->is_set()) {
            throw new base_element_struct_exception('attribute_has_not_value', $this->get_name());
        }
        backup_structure_dbops::insert_backup_ids_record($backupid, $this->annotationitem, $this->get_value());
    }

}
