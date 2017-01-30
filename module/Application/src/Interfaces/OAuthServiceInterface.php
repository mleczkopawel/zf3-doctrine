<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 15:45
 */

namespace Application\Interfaces;


interface OAuthServiceInterface
{
    public function getProvider($name);
    public function generateAuthButton();
    public function oAuthorize();

}