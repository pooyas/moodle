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
 * Abstract base driver class for blowfish encryption.
 *
 * @category  Horde
 */
abstract class Horde_Crypt_Blowfish_Base
{
    /**
     * Cipher method.
     *
     * @var string
     */
    public $cipher;

    /**
     * Initialization vector.
     *
     * @var string
     */
    public $iv = null;

    /**
     * Encryption key.
     *
     * @var string
     */
    public $key;

    /**
     * Is this driver supported on this system?
     *
     * @return boolean  True if supported.
     */
    static public function supported()
    {
        return true;
    }

    /**
     * Constructor.
     *
     * @param string $cipher  Either 'ecb' or 'cbc'.
     */
    public function __construct($cipher)
    {
        $this->cipher = $cipher;
    }

    /**
     * Encrypts a string.
     *
     * @param string $text  The string to encrypt.
     *
     * @return string  The ciphertext.
     * @throws Horde_Crypt_Blowfish_Exception
     */
    abstract public function encrypt($text);

    /**
     * Decrypts a string.
     *
     * @param string $text  The string to encrypt.
     *
     * @return string  The ciphertext.
     * @throws Horde_Crypt_Blowfish_Exception
     */
    abstract public function decrypt($text);

    /**
     * Sets the initialization vector (required for CBC mode).
     *
     * @param string $iv  Initialization vector.
     */
    public function setIv($iv = null)
    {
        $this->iv = is_null($iv)
            ? substr(new Horde_Support_Randomid(), 0, 8)
            : $iv;
    }

    /**
     * Pad text to match blocksize length.
     *
     * @param string $text     Unpadded text.
     * @param boolean $ignore  Don't pad if already at blocksize length.
     *
     * @return string  Padded text.
     */
    protected function _pad($text, $ignore = false)
    {
        $blocksize = Horde_Crypt_Blowfish::BLOCKSIZE;
        $padding = $blocksize - (strlen($text) % $blocksize);

        return ($ignore && ($padding == $blocksize))
            ? $text
            : $text . str_repeat(chr($padding), $padding);
    }

    /**
     * Unpad text from blocksize boundary.
     *
     * @param string $text  Padded text.
     *
     * @return string  Unpadded text.
     */
    protected function _unpad($text)
    {
        return substr($text, 0, ord(substr($text, -1)) * -1);
    }

}
