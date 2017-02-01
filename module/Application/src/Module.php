<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\AuthController;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

/**
 * Class Module
 * @package Application
 */
class Module
{

    //    KONFIGURACJA GLOBALNYCH
    /**
     *
     */
    const VERSION = '3.0.2aaaasdasdasdasddev';

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event) {
        $eventManager = $event->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [
            $this,
            'beforeDispatch',
        ], 100);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, [
            $this,
            'beforeDispatch',
        ], -100);
    }

    /**
     * @param MvcEvent $event
     */
    public function beforeDispatch(MvcEvent $event) {
        $response = $event->getResponse();

        $whiteList = [
            AuthController::class . '-index',
            AuthController::class . '-login',
            AuthController::class . '-logout',
            AuthController::class . '-callback',
            AuthController::class . '-register',
            AuthController::class . '-check',
        ];

        $controller = $event->getRouteMatch()->getParam('controller');
        $action = $event->getRouteMatch()->getParam('action');
        $requestedResource = $controller . '-' . $action;

        $session = new Container('User');

        if (!$session->offsetExists('name')) {
            if ($requestedResource != AuthController::class . '-index' && !in_array($requestedResource, $whiteList)) {
                $url = 'auth';
                $response->setHeaders($response->getHeaders()->addHeaderLine('Location', $url));
                $response->setStatusCode(302);
            }
            $response->sendHeaders();
        }

    }

    /**
     * @param MvcEvent $event
     */
    public function afterDispatch(MvcEvent $event) {}
}
