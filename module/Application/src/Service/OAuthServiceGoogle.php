<?php
/**
 * User: Paweł Mleczko
 * Date: 30.01.2017
 * Time: 21:29
 */

namespace Application\Service;


use Application\Interfaces\OAuthServiceInterface;
use League\OAuth2\Client\Provider\Google;

class OAuthServiceGoogle implements OAuthServiceInterface
{

    private $_provider;

    public function getProvider($name)
    {
        $config = require ROOT_PATH . '/config/providers.php';
        $config = $config[$name];

        $provider = new Google($config);

        $this->_provider = $provider;
    }

    public function generateAuthButton()
    {
        if (!isset($_GET['code'])) {
            $authUrl = $this->_provider->getAuthorizationUrl([
                'scope' => ['email'],
            ]);
            $_SESSION['oauth2state'] = $this->_provider->getState();

            return $authUrl;
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);

            return false;
        }
        return false;
    }

    public function oAuthorize()
    {
        $token = $this->_provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        if ($user = $this->_provider->getResourceOwner($token)){
            return [
                'code' => 1,
                'user' => $user
            ];
        } else {
            return [
                'code' => 0,
                'message' => 'Nie mogę zalogować',
            ];
        }
    }
}