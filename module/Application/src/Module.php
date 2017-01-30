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

class Module
{

    //    KONFIGURACJA GLOBALNYCH
    const VERSION = '3.0.2aaaasdasdasdasddev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

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

    public function beforeDispatch(MvcEvent $event) {
        $response = $event->getResponse();

        $whiteList = [
            AuthController::class . '-index',
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

    public function afterDispatch(MvcEvent $event) {}
}
