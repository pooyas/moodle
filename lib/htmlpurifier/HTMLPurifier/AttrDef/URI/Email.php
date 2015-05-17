<?php


/**
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
*/

abstract class HTMLPurifier_AttrDef_URI_Email extends HTMLPurifier_AttrDef
{

    /**
     * Unpacks a mailbox into its display-name and address
     * @param string $string
     * @return mixed
     */
    public function unpack($string)
    {
        // needs to be implemented
    }

}

// sub-implementations

// vim: et sw=4 sts=4
