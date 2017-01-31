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
     * @var
     */
    private $_provider;

    /**
     * @param $name
     * @return mixed|void
     */
    public function getProvider($name)
    {
        $config = require ROOT_PATH . '/config/providers.php';
        $config = $config[$name];

        $provider = new Facebook($config);

        $this->_provider = $provider;
    }

    /**
     * @return bool|string
     */
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

    /**
     * @return array
     */
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