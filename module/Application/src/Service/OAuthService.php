<?php
/**
 * User: mlecz
 * Date: 30.01.2017
 * Time: 13:09
 */

namespace Application\Service;

use Application\Interfaces\OAuthServiceInterface;
use Exception;
use League\OAuth2\Client\Provider\Facebook;

class OAuthService implements OAuthServiceInterface
{
    private $_provider;

    public function getProvider($name)
    {
        $config = require ROOT_PATH . '/config/providers.php';
        $config = $config[$name];
        $clientId = $config['id'];
        $clientSecret = $config['secret'];
        $redirectUrl = $config['redirect'];

        $provider = new Facebook([
            'clientId'          => $clientId,
            'clientSecret'      => $clientSecret,
            'redirectUri'       => $redirectUrl,
            'graphApiVersion'   => 'v2.8',
        ]);

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