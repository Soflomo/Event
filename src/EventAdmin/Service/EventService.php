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

namespace Soflomo\EventAdmin\Service;

use Soflomo\Event\Entity\EventInterface;
use Soflomo\Event\Repository\EventRepository;
use Soflomo\Event\Repository\ListRepository;

use Doctrine\ORM\EntityManager;

use Zend\EventManager;

class EventService implements EventManager\EventManagerAwareInterface
{
    protected $entityManager;
    protected $listRepository;
    protected $eventRepository;

    protected $eventManager;

    public function __construct(EntityManager $em, ListRepository $listRepository, EventRepository $eventRepository)
    {
        $this->entityManager   = $em;
        $this->listRepository  = $listRepository;
        $this->eventRepository = $eventRepository;
    }

    public function create(EventInterface $event)
    {
        $this->trigger(__FUNCTION__ . '.pre', array('event' => $event));

        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();

        $this->trigger(__FUNCTION__ . '.post', array('event' => $event));
    }

    public function update(EventInterface $event)
    {
        $this->trigger(__FUNCTION__ . '.pre', array('event' => $event));

        $this->getEntityManager()->flush();

        $this->trigger(__FUNCTION__ . '.post', array('event' => $event));
    }

    public function delete(EventInterface $event)
    {
        $this->trigger(__FUNCTION__ . '.pre', array('event' => $event));

        $this->getEntityManager()->remove($event);
        $this->getEntityManager()->flush();

        $this->trigger(__FUNCTION__ . '.post', array('event' => $event));
    }

    public function trigger($name, array $parameters = array())
    {
        $event = new EventManager\Event;
        $event->setTarget($this);
        $event->setName($name);
        $event->setParams($parameters);

        $this->getEventManager()->trigger($event);
    }

    /**
     * Getter for eventManager
     *
     * @return mixed
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager\EventManager);
        }
        return $this->eventManager;
    }

    /**
     * Setter for eventManager
     *
     * @param mixed $eventManager Value to set
     * @return self
     */
    public function setEventManager(EventManager\EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_called_class(),
        ));

        $this->eventManager = $eventManager;
        return $this;
    }

    public function getListRepository()
    {
        return $this->listRepository;
    }

    public function getEventRepository()
    {
        return $this->eventRepository;
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }
}
