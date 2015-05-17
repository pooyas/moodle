<?php


/**
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
*/

class HTMLPurifier_HTMLModule_Tidy_Transitional extends HTMLPurifier_HTMLModule_Tidy_XHTMLAndHTML4
{
    /**
     * @type string
     */
    public $name = 'Tidy_Transitional';

    /**
     * @type string
     */
    public $defaultLevel = 'heavy';
}

// vim: et sw=4 sts=4
