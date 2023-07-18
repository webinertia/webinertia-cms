<?php

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Webinertia\Mvc\Controller\Factory\ControllerFactory;
use Webinertia\Mvc\Service;

return [
    'service_manager' => [
        'factories' => [
            // Replace the default service with ours so we can keep track of the custom codes and messages
            'Response' => Service\ResponseFactory::class,
        ],
    ],
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
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'upload-manager' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/admin/upload[/:action]',
                    'defaults' => [
                        'controller' => Controller\AdminUploadController::class,
                        'action' => 'manager',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class       => ControllerFactory::class,
            Controller\AdminUploadController::class => ControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label'  => 'Home',
                'route'  => 'home',
                'class'  => 'nav-link',
                'order'  => -999,
                'action' => 'index',
            ],
            [
                'label'  => 'Upload',
                'route'  => 'upload-manager',
                'action' => 'manager',
                'class'  => 'nav-link',
            ],
        ],
    ],
];
