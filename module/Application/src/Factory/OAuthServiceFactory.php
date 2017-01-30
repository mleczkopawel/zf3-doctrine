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

    private $_provider;

    public function create($providerName) {
        switch ($providerName) {
            case 'fb': {
                $this->_provider = (new OAuthServiceFacebook())->getProvider('fb');
            } break;
            case 'google': {
                $this->_provider = (new OAuthServiceGoogle())->getProvider('google');
            } break;
            default: {
                $this->_provider = false;
            }
        }
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