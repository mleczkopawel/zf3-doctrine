<?php
/**
 * User: mlecz
 * Date: 07.02.2017
 * Time: 13:04
 */

namespace Cron;

use Admin\Controller\IndexController;
use Admin\Factory\DoctrineControllerFactory;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'zf-admin' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '[/:locale]/zf-admin[/:action]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                        'locale' => LOCALE,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => DoctrineControllerFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'admin/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
