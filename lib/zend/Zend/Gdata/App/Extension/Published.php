<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @version    $Id$
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * @see Zend_Gdata_App_Extension
 */
require_once 'Zend/Gdata/App/Extension.php';

/**
 * Represents the atom:published element
 *
 * @category   Zend
 */
class Zend_Gdata_App_Extension_Published extends Zend_Gdata_App_Extension
{

    protected $_rootElement = 'published';

    public function __construct($text = null)
    {
        parent::__construct();
        $this->_text = $text;
    }

}
