<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;




use Application\Controller\AdminController;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'users' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/users[/:action]',
                    'defaults' => [
                        'controller' => Controller\UsersController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/admin[/:action]',
                    'defaults' => [
                        'controller' => Controller\AdminController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'jouer' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/jouer[/:action]',
                    'defaults' => [
                        'controller' => Controller\GameController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'register' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/register[/:action]',
                    'defaults' => [
                        'controller' => Controller\RegisterController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'historique_jeu' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/historique_jeu[/:action]',
                    'defaults' => [
                        'controller' => Controller\GameHistoryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'session_containers' => [
        'Administration'
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class =>
                            Controller\Factory\IndexControllerFactory::class,
            Controller\UsersController::class =>
                            Controller\Factory\UsersControllerFactory::class,
            Controller\JwtController::class =>
                            Controller\Factory\JwtServiceFactory::class,
            Controller\GameController::class =>
                            Controller\Factory\GameControllerFactory::class,
            Controller\RegisterController::class=>
                            Controller\Factory\RegisterControllerFactory::class,
            Controller\GameHistoryController::class=>
                            Controller\Factory\GameHistoryControllerFactory::class,
            Controller\AdminController::class=>
                            Controller\Factory\AdminControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [

            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
        'authentication' => [
            'orm_default' => [
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\Admin',
                'identity_property' => 'username',
                'credential_property' => 'password',
                'credential_callable' => 'Application\Controller\AdminController::verifyCredential',
            ],
        ],
    ],

];
