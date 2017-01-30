<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 13:09
 */

namespace Application\Service;

use Application\Interfaces\OAuthServiceInterface;
use League\OAuth2\Client\Provider\Facebook;

/**
 * Class OAuthServiceFacebook
 * @package Application\Service
 */
class OAuthServiceFacebook implements OAuthServiceInterface
{
    /**
     * @param $name
     * @return Facebook
     */
    public function getProvider($name)
    {
        $config = require ROOT_PATH . '/config/providers.php';
        $config = $config[$name];

        $provider = new Facebook($config);

        return $provider;
    }
}