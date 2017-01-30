<?php
/**
 * User: Paweł Mleczko
 * Date: 30.01.2017
 * Time: 21:31
 */

namespace Application\Factory;


use Application\Service\OAuthServiceFacebook;
use Application\Service\OAuthServiceGoogle;

class OAuthServiceFactory
{
    public function create($providerName) {
        switch ($providerName) {
            case 'fb': {
                return new OAuthServiceFacebook();
            } break;
            case 'google': {
                return new OAuthServiceGoogle();
            }
            default: {
                return false;
            }
        }
    }
}