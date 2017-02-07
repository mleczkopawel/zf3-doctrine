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

    private $_method = 'both';
    /**
     * UserPassword constructor.
     * @param null $_method
     */
    public function __construct($_method = null)
    {
        $this->_method = $_method;
    }

    /**
     * @param $password
     * @return string
     */
    public function create($password)
    {
        if ($this->_method == 'md5') {
            return md5($this->_salt . $password);
        } elseif ($this->_method == 'sha1') {
            return sha1($this->_salt . $password);
        } else {
            return sha1($this->_salt . md5($this->_salt . $password));
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
        } elseif ($this->_method == 'sha1') {
            return $hash == sha1($this->_salt . $password);
        } else {
            return $hash == sha1($this->_salt . md5($this->_salt . $password));
        }
    }
}