<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\AuthController;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Service\Authentication\AuthenticationServiceFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '[/:locale]/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                        'locale' => 'pl',
                    ],
                ],
            ],
            'doctrine' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '[/:locale]/doctrine[/:action]',
                    'defaults' => [
                        'controller' => Controller\DoctrineController::class,
                        'action'     => 'index',
                        'locale' => 'pl',
                    ],
                ],
            ],
            'auth' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '[/:locale]/auth',
                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'index',
                        'locale' => 'pl',
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
                            'constrains' => array(
                                'provider' => 'fb,google',
                            ),
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
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class    => InvokableFactory::class,
            Controller\DoctrineController::class => Factory\DoctrineControllerFactory::class,
            Controller\AuthController::class => Factory\AuthControllerFactory::class
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
            \Zend\I18n\Translator\TranslatorInterface::class => \Zend\I18n\Translator\TranslatorServiceFactory::class,
        ]
    ],
    'controller_plugins' => [
        'invokables' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class
        ],
    ],
    'translator' => [
        'locale' => 'pl_PL',
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
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
