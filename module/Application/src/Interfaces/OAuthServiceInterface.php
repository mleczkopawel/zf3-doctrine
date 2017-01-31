<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:45
 */

namespace Application\Interfaces;

/**
 * Interface OAuthServiceInterface
 * @package Application\Interfaces
 */
interface OAuthServiceInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function getProvider($name);

    /**
     * @return mixed
     */
    public function generateAuthButton();

    /**
     * @return mixed
     */
    public function oAuthorize();

}