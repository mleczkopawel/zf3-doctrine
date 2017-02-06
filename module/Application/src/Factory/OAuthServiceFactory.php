<?php
/**
 * User: Paweł Mleczko
 * Date: 30.01.2017
 * Time: 21:31
 */

namespace Application\Factory;

use Application\Service\OAuthServiceFacebook;
use Application\Service\OAuthServiceGoogle;

/**
 * Class OAuthServiceFactory
 * @package Application\Factory
 */
class OAuthServiceFactory
{

    /**
     * @param $providerName
     * @return OAuthServiceFacebook|OAuthServiceGoogle|bool
     */
    public function create($providerName)
    {
        switch ($providerName) {
            case 'fb': {
                $provider = new OAuthServiceFacebook();
                $provider->getProvider($providerName);
            }
                break;
            case 'google': {
                $provider = new OAuthServiceGoogle();
                $provider->getProvider($providerName);
            }
                break;
        }

        if (isset($provider)) {
            return $provider;
        } else {
            return false;
        }
    }
}