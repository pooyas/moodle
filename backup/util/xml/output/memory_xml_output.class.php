<?php

/**
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

/**
 * This class implements one @xml_output able to store and return output in memory
 *
 * Although possible to use, has been defined as not supporting buffering for
 * testing purposes. get_allcontents() will return the contents after ending.
 *
 * TODO: Finish phpdocs
 */
class memory_xml_output extends xml_output{

    protected $allcontents; // Here we'll store all the written contents

    public function __construct() {
        $this->allcontents = '';
        parent::__construct(false); // disable buffering
    }

    public function get_allcontents() {
        if ($this->running !== false) {
            throw new xml_output_exception('xml_output_not_stopped');
        }
        return $this->allcontents;
    }

// Private API starts here

    protected function init() {
        // Easy :-)
    }

    protected function finish() {
        // Trivial :-)
    }

    protected function send($content) {
        // Accumulate contents
        $this->allcontents .= $content;
    }

}
