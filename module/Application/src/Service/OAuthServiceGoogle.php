<?php
/**
 * User: Paweł Mleczko
 * Date: 30.01.2017
 * Time: 21:29
 */

namespace Application\Service;


use Application\Interfaces\OAuthServiceInterface;
use League\OAuth2\Client\Provider\Google;

/**
 * Class OAuthServiceGoogle
 * @package Application\Service
 */
class OAuthServiceGoogle implements OAuthServiceInterface
{

    /**
     * @param $name
     * @return Google
     */
    public function getProvider($name)
    {
        $config = require ROOT_PATH . '/config/providers.php';
        $config = $config[$name];

        $provider = new Google($config);

        return $provider;
    }
}