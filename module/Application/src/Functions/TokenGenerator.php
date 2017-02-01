<?php
/**
 * User: mlecz
 * Date: 31.01.2017
 * Time: 14:02
 */

namespace Application\Functions;

/**
 * Class TokenGenerator
 * @package Application\Functions
 */
class TokenGenerator
{
    /**
     * @param $len
     * @return string
     */
    public function string($len)
    {
        $str['str'] = array(true, true, true, true);
        $letters = 'abcdefghijklmnouprstuwvxyz';
        $values = '';
        $rando = '';
        if ($str['str'][0]) {
            $values .= '0123456789';
        }
        if ($str['str'][1]) {
            $values .= $letters;
        }
        if ($str['str'][2]) {
            $values .= strtoupper($letters);
        }
        for ($i = 0, $length = (strlen($values) - 1); $i < $len; $i++) {
            $rando .= substr($values, mt_rand(0, $length), 1);
        }
        return $rando;
    }
}