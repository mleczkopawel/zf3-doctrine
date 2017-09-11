<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\AuthController;
use Application\Controller\RoomController;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\I18n\Translator\TranslatorServiceFactory;
use Zend\I18n\View\Helper\Translate;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'main' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/main',
                    'defaults' => [
                        'controller' => MainController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'rooms' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/rooms',
                    'defaults' => [
                        'controller' => RoomController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'auth' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/auth',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'callback' => [
                        'type' => Segment::class,
                        'options' => [
                            'route' => '/callback/:provider',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'callback',
                            ],
                        ],
                    ],
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/login',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'login',
                            ],
                        ],
                    ],
                    'register' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/register',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'register',
                            ],
                        ],
                    ],
                    'logout' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/logout',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'logout',
                            ],
                        ],
                    ],
                    'check' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/check',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'check',
                            ],
                        ],
                    ],
                    'reset' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/reset',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'resetPassword',
                            ],
                        ],
                    ],
                    'resetPass' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/resetPass',
                            'defaults' => [
                                'controller' => AuthController::class,
                                'action' => 'resetPassCall',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Główna',
                'route' => 'main',
            ],
            [
                'label' => 'Pokoje',
                'route' => 'rooms',
                'pages' => [
                    [
                        'label'  => 'Pokoje',
                        'route'  => 'rooms',
                        'action' => 'rooms',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => Factory\AuthControllerFactory::class,
            Controller\RoomController::class => Factory\RoomFactory::class,
            Controller\MainController::class => InvokableFactory::class
        ],
    ],
    'doctrine' => [
        'authentication' => [
            'orm_default' => [
                'object_manager' => EntityManager::class,
                'identity_class' => User::class,
                'identity_property' => 'email',
                'credential_property' => 'password'
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            TranslatorInterface::class => TranslatorServiceFactory::class,
        ]
    ],
    'controller_plugins' => [
        'invokables' => [
            'translate' => Translate::class
        ],
    ],
    'translator' => [
        'locale' => LOCALE,
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => ROOT_PATH . '/module/Application/language',
                'pattern' => '%s.mo',
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
