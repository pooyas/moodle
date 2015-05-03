<?php


/**
 * @package    lioncore
 * @subpackage backup-xml
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Abstract class to extend in order to transform @xml_writer text contents
 *
 * Implementations of this class will provide @xml_writer with the ability of
 * transform xml text contents before being sent to output. Useful for various
 * things like link transformations in the backup process and others.
 *
 * Just define the process() method, program the desired transformations and done!
 *
 * TODO: Finish phpdocs
 */
abstract class xml_contenttransformer {

    abstract public function process($content);
}
