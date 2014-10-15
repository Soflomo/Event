<?php
/**
 * Copyright (c) 2014 Soflomo.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author      Jurian Sluiman <jurian@soflomo.com>
 * @copyright   2014 Soflomo.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://soflomo.com
 */

return array(
    'soflomo_event' => array(
        'list_entity_class'      => 'Soflomo\Event\Entity\EventList',
        'category_entity_class'  => 'Soflomo\Event\Entity\Category',
        'event_entity_class'     => 'Soflomo\Event\Entity\Event',

        'upcoming_range'       => 'P30D',
        'upcoming_limit'       => 10,
        'past_range'           => 'P30D',
        'past_limit'           => 10,
        'admin_paginator_listing_limit' => 10,
        'admin_secondary_listing_limit' => 10,

        'sitemap'                => array(
            'changefreq' => '',
            'priority'   => '',
        ),
    ),

    'ensemble_kernel' => array(
        'routes' => array(
            'event' => array(
                'options' => array(
                    'defaults' => array(
                        'controller' => 'Soflomo\Event\Controller\EventController',
                        'action'     => 'upcoming',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'view' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/:event[/:slug]',
                            'defaults' => array(
                                'action' => 'view',
                            ),
                            'constraints' => array(
                                'event' => '[0-9]+',
                                'slug'  => '[a-zA-Z0-9-_.]+',
                            ),
                        ),
                    ),
                    'category' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/category/:category[/:page]',
                            'defaults' => array(
                                'action' => 'category',
                                'page'   => '1',
                            ),
                            'constraints' => array(
                                'category' => '[a-zA-Z0-9-_.]+',
                                'page'     => '[0-9]+',
                            ),
                        ),
                    ),
                    'archive' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/archive[/:page]',
                            'defaults' => array(
                                'action' => 'archive',
                                'page'   => '1',
                            ),
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                        ),
                    ),
                    'by-date' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/:from/:to',
                            'defaults' => array(
                                'action' => 'by-date',
                            ),
                            'constraints' => array(
                                'from' => '[0-9]{2}-[0-9]{2}-[0-9]{4}',
                                'to'   => '[0-9]{2}-[0-9]{2}-[0-9]{4}',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'eventlist' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/event/:list[/:page]',
                            'defaults' => array(
                                'controller' => 'Soflomo\EventAdmin\Controller\EventController',
                                'action'     => 'index',
                                'page'       => 1,
                            ),
                            'constraints' => array(
                                'event' => '[a-zA-Z0-9-_]+',
                                'page' => '[0-9]+',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes'  => array(
                            'past' => array(
                                'type'    => 'literal',
                                'options' => array(
                                    'route' => '/past',
                                    'defaults' => array(
                                        'action' => 'past',
                                    ),
                                ),
                            ),
                            'event' => array(
                                'type'    => 'segment',
                                'options' => array(
                                    'route' => '/event'
                                ),
                                'may_terminate' => false,
                                'child_routes'  => array(
                                    'view' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route' => '/:event',
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                            'constraints' => array(
                                                'event' => '[0-9]+'
                                            ),
                                        ),
                                    ),
                                    'create' => array(
                                        'type'    => 'literal',
                                        'options' => array(
                                            'route' => '/new',
                                            'defaults' => array(
                                                'action' => 'create',
                                            ),
                                        ),
                                    ),
                                    'update' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route' => '/:event/edit',
                                            'defaults' => array(
                                                'action' => 'update',
                                            ),
                                            'constraints' => array(
                                                'event' => '[0-9]+'
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route' => '/:event/delete',
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                            'constraints' => array(
                                                'event' => '[0-9]+'
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'category' => array(
                                'type'    => 'literal',
                                'options' => array(
                                    'route' => '/category',
                                    'defaults' => array(
                                        'controller' => 'Soflomo\EventAdmin\Controller\CategoryController',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'view' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route' => '/:category',
                                            'defaults' => array(
                                                'action' => 'view',
                                            ),
                                            'constraints' => array(
                                                'category' => '[0-9]+'
                                            ),
                                        ),
                                    ),
                                    'create' => array(
                                        'type'    => 'literal',
                                        'options' => array(
                                            'route' => '/new',
                                            'defaults' => array(
                                                'action' => 'create',
                                            ),
                                        ),
                                    ),
                                    'update' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route' => '/:category/edit',
                                            'defaults' => array(
                                                'action' => 'update',
                                            ),
                                            'constraints' => array(
                                                'category' => '[0-9]+'
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'segment',
                                        'options' => array(
                                            'route' => '/:category/delete',
                                            'defaults' => array(
                                                'action' => 'delete',
                                            ),
                                            'constraints' => array(
                                                'category' => '[0-9]+'
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'ensemble_admin' => array(
        'routes' => array(
            'event' => array(
                'event' => array(
                    'type' => 'literal',
                    'options' => array(
                        'route' => '/',
                        'defaults' => array(
                            'controller' => 'Soflomo\EventAdmin\Controller\IndexController',
                            'action'     => 'index'
                        ),
                    )
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'form_elements' => array(
        'factories' => array(
            'Soflomo\EventAdmin\Form\EventForm'           => 'Soflomo\EventAdmin\Factory\EventFormFactory',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Soflomo\Event\Options\ModuleOptions'         => 'Soflomo\Event\Factory\ModuleOptionsFactory',

            'Soflomo\Event\Repository\ListRepository'     => 'Soflomo\Event\Factory\ListRepositoryFactory',
            'Soflomo\Event\Repository\CategoryRepository' => 'Soflomo\Event\Factory\CategoryRepositoryFactory',
            'Soflomo\Event\Repository\EventRepository'    => 'Soflomo\Event\Factory\EventRepositoryFactory',

            'Soflomo\Event\Hydrator\Strategy\CategoryStrategy' => 'Soflomo\Event\Factory\CategoryHydratorStrategyFactory',

            'Soflomo\EventAdmin\Form\Category'            => 'Soflomo\EventAdmin\Factory\CategoryFormFactory',

            'Soflomo\EventAdmin\Service\EventService'     => 'Soflomo\EventAdmin\Factory\EventServiceFactory',
            'Soflomo\EventAdmin\Service\Category'         => 'Soflomo\EventAdmin\Factory\CategoryServiceFactory',
        ),
    ),

    'controllers' => array(
        'factories' => array(
            'Soflomo\Event\Controller\EventController'         => 'Soflomo\Event\Factory\EventControllerFactory',
            'Soflomo\EventAdmin\Controller\EventController'    => 'Soflomo\EventAdmin\Factory\EventControllerFactory',
            'Soflomo\EventAdmin\Controller\CategoryConroller'  => 'Soflomo\EventAdmin\Factory\CategoryControllerFactory',
            'Soflomo\EventAdmin\Controller\IndexController'    => 'Soflomo\EventAdmin\Factory\IndexControllerFactory',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            'soflomo_Event' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/mapping'
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Soflomo\Event\Entity' => 'soflomo_Event'
                ),
            ),
        ),
        'entity_resolver' => array(
            'orm_default' => array(
                'resolvers' => array(
                    'Soflomo\Event\Entity\EventInterface'    => 'Soflomo\Event\Entity\Event',
                    'Soflomo\Event\Entity\CategoryInterface' => 'Soflomo\Event\Entity\Category',
                    'Soflomo\Event\Entity\ListInterface'     => 'Soflomo\Event\Entity\EventList',
                ),
            ),
        ),
    ),
);
