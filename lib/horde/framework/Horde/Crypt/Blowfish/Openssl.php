<?php
/**
 * Copyright 2012-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Openssl driver for blowfish encryption.
 *
 * @category  Horde
 */
class Horde_Crypt_Blowfish_Openssl extends Horde_Crypt_Blowfish_Base
{
    /**
     */
    static public function supported()
    {
        return extension_loaded('openssl');
    }

    /**
     */
    public function encrypt($text)
    {
        if (PHP_VERSION_ID <= 50302) {
            return @openssl_encrypt($text, 'bf-' . $this->cipher, $this->key, true);
        } elseif (PHP_VERSION_ID == 50303) {
            // Need to mask error output, since an invalid warning message was
            // issued prior to 5.3.4 for empty IVs in ECB mode.
            return @openssl_encrypt($text, 'bf-' . $this->cipher, $this->key, true, strval($this->iv));
        }

        return openssl_encrypt($text, 'bf-' . $this->cipher, $this->key, true, strval($this->iv));
    }

    /**
     */
    public function decrypt($text)
    {
        return (PHP_VERSION_ID <= 50302)
            ? openssl_decrypt($text, 'bf-' . $this->cipher, $this->key, true)
            : openssl_decrypt($text, 'bf-' . $this->cipher, $this->key, true, strval($this->iv));
    }

}
