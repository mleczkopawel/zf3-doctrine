<?php
/**
 * User: mlecz
 * Date: 07.02.2017
 * Time: 13:04
 */

namespace Cron;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'cron' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '[/:locale]/cron[/:action]',
                    'defaults' => [
                        'controller' => Controller\CronController::class,
                        'action' => 'index',
                        'locale' => LOCALE,
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\CronController::class => Factory\DoctrineControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
