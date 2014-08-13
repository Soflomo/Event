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

namespace Soflomo\Event\Controller;

use Soflomo\Event\Exception;
use Soflomo\Event\Options\ModuleOptions;
use Soflomo\Event\Repository\EventRepository;
use Soflomo\Event\Repository\ListRepository;

use BaconStringUtils\Slugifier;

use Zend\Mvc\Controller\AbstractActionController;

class EventController extends AbstractActionController
{
    /**
     * @var ListRepository
     */
    protected $listRepository;

    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @var ModuleOptions
     */
    protected $options;

    public function __construct(ListRepository $listRepository, EventRepository $eventRepository, ModuleOptions $options)
    {
        $this->listRepository  = $listRepository;
        $this->eventRepository = $eventRepository;
        $this->options         = $options;
    }

    public function upcomingAction()
    {
        $list   = $this->getList();
        $range  = $this->getOptions()->getUpcomingRange();
        $limit  = $this->getOptions()->getUpcomingLimit();
        $events = $this->getEventRepository()->findUpcoming($list, $range, $limit);

        return array(
            'events' => $events,
        );
    }

    public function pastAction()
    {
        $list   = $this->getList();
        $range  = $this->getOptions()->getPastRange();
        $limit  = $this->getOptions()->getPastLimit();
        $events = $this->getEventRepository()->findPast($list, $range, $limit);

        return array(
            'events' => $events,
        );
    }

    public function viewAction()
    {
        $list  = $this->getList();
        $id    = $this->params('event');
        $event = $this->getEventRepository()->findEvent($list, $id);

        if (null === $event) {
            throw new Exception\EventNotFoundException(sprintf(
                'Event with id "%s" not found', $id
            ));
        }

        $slugifier = new Slugifier;
        $slug      = $slugifier->slugify($event->getName());
        if ($slug !== $this->params('slug')) {
            return $this->redirect()->toRoute(null, array(
                'event' => $event->getId(),
                'slug'  => $slug,
            ))->setStatusCode(301);
        }

        return array(
            'event' => $event,
        );
    }

    protected function getList()
    {
        $page = $this->getPage();
        $id   = $page->getModuleId();
        $list = $this->getListRepository()->find($id);

        if (null === $list) {
            throw new Exception\EventListNotFoundException(sprintf(
                'Event list with id "%s" not found', $id
            ));
        }

        return $list;
    }

    protected function getPage()
    {
        return $this->getEvent()->getParam('page');
    }

    protected function getListRepository()
    {
        return $this->listRepository;
    }

    protected function getEventRepository()
    {
        return $this->eventRepository;
    }

    protected function getOptions()
    {
        return $this->options;
    }
}
