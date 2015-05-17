<?php


/**
 * Mustache helper that will add JS to the end of the page.
 *
 * @category   output
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\output;

/**
 * Lazy create a uniqid per instance of the class. The id is only generated
 * when this class it converted to a string.
 *
 */
class mustache_uniqid_helper {

    /** @var string $uniqid The unique id */
    private $uniqid = null;

    /**
     * Init the random variable and return it as a string.
     *
     * @return string random id.
     */
    public function __toString() {
        if ($this->uniqid === null) {
            $this->uniqid = \html_writer::random_id(uniqid());
        }
        return $this->uniqid;
    }
}
