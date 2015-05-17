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

/** @see Zend_Auth_Adapter_Interface */
require_once 'Zend/Auth/Adapter/Interface.php';

/**
 * Base abstract class for AMF authentication implementation
 *
 */
abstract class Zend_Amf_Auth_Abstract implements Zend_Auth_Adapter_Interface
{
    protected $_username;
    protected $_password;

    public function setCredentials($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
    }
}
