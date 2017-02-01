<?php
/**
 * User: mlecz
 * Date: 31.01.2017
 * Time: 10:30
 */

namespace Application\Functions;

/**
 * Class UserPassword
 * @package Application\Functions
 */
class UserPassword
{
    /**
     * @var string
     */
    private $_salt = 'ksd645ger98r51sv68sr35srgs8rg4srvb324rs78';
    /**
     * @var null|string
     */
    private $_method = 'sha1';

    /**
     * UserPassword constructor.
     * @param null $_method
     */
    public function __construct($_method = null)
    {
        if (!is_null($_method)) {
            $this->_method = $_method;
        }
    }

    /**
     * @param $password
     * @return string
     */
    public function create($password)
    {
        if ($this->_method == 'md5') {
            return md5($this->_salt . $password);
        } else {
            return sha1($this->_salt . $password);
        }
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public function verify($password, $hash)
    {
        if ($this->_method == 'md5') {
            return $hash == md5($this->_salt . $password);
        } else {
            return $hash == sha1($this->_salt . $password);
        }
    }
}