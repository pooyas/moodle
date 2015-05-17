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
 * Zend_XmlRpc_Value_Scalar
 */
require_once 'Zend/XmlRpc/Value/Scalar.php';


/**
 * @category   Zend
 */
class Zend_XmlRpc_Value_Nil extends Zend_XmlRpc_Value_Scalar
{

    /**
     * Set the value of a nil native type
     *
     */
    public function __construct()
    {
        $this->_type = self::XMLRPC_TYPE_NIL;
        $this->_value = null;
    }

    /**
     * Return the value of this object, convert the XML-RPC native nill value into a PHP NULL
     *
     * @return null
     */
    public function getValue()
    {
        return null;
    }
}

