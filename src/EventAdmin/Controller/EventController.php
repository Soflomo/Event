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

namespace Soflomo\EventAdmin\Controller;

use Soflomo\Event\Entity\Event;
use Soflomo\Event\Entity\EventList;
use Soflomo\Event\Exception;
use Soflomo\Event\Options\ModuleOptions;
use Soflomo\EventAdmin\Form\EventForm;
use Soflomo\EventAdmin\Service\EventService;

use Zend\Mvc\Controller\AbstractActionController;

class EventController extends AbstractActionController
{
    /**
     * @var EventService;
     */
    protected $service;

    /**
     * @var EventForm
     */
    protected $form;

    /**
     * @var ModuleOptions
     */
    protected $options;

    public function __construct(EventService $service, EventForm $form, ModuleOptions $options = null)
    {
        $this->service = $service;
        $this->form    = $form;

        if (null !== $options) {
            $this->options = $options;
        }
    }

    public function indexAction()
    {
        $list  = $this->getList();
        $page  = $this->params('page');

        $paginatorLimit = $this->getOptions()->getAdminPaginatorListingLimit();
        $secondaryLimit = $this->getOptions()->getAdminSecondaryListingLimit();
        $pastRange      = $this->getOptions()->getPastRange();

        $paginator  = $this->getEventRepository()->getUpcomingPaginator($list, $page, $paginatorLimit);
        $pastEvents = $this->getEventRepository()->findPast($list, $pastRange, $secondaryLimit);

        return array(
            'list'       => $list,
            'paginator'  => $paginator,
            'pastEvents' => $pastEvents
        );
    }

    public function pastAction()
    {
        $list  = $this->getList();
        $page  = $this->params('page');

        $limit     = $this->getOptions()->getAdminPaginatorListingLimit();
        $paginator = $this->getEventRepository()->getPastPaginator($list, $page, $limit);

        return array(
            'list'       => $list,
            'paginator'  => $paginator,
        );
    }

    public function viewAction()
    {
        $list = $this->getList();
        $event = $this->getEventEntity($list);

        $this->addPage(array(
            'label'  => $event->getName(),
            'route'  => 'zfcadmin/eventlist/event/view',
            'params' => array('list' => $list->getSlug(), 'event' => $event->getId()),
            'active' => true,
        ));

        return array(
            'list'  => $list,
            'event' => $event,
        );
    }

    public function createAction()
    {
        $list  = $this->getList();
        $event = $this->getEventEntity($list, true);
        $form  = $this->getForm();
        $form->bind($event);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $this->getService()->create($event);

                $this->flashMessenger()->addMessage('Event created successfully.');
                return $this->redirect()->toRoute('zfcadmin/eventlist/event/view', array(
                    'list'  => $list->getSlug(),
                    'event' => $event->getId(),
                ));
            }
        }

        $this->addPage(array(
            'label'  => 'New event',
            'route'  => 'zfcadmin/eventlist/event/create',
            'params' => array('list' => $list->getSlug()),
            'active' => true,
        ));

        return array(
            'list'    => $list,
            'form'    => $form,
        );
    }

    public function updateAction()
    {
        $list  = $this->getList();
        $event = $this->getEventEntity($list);
        $form  = $this->getForm();
        $form->bind($event);

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $this->getService()->update($event);

                $this->flashMessenger()->addMessage('Event saved successfully.');
                return $this->redirect()->toRoute('zfcadmin/eventlist/event/update', array(
                    'list'  => $list->getSlug(),
                    'event' => $event->getId(),
                ));
            }
        }

        $this->addPage(array(
            'label'  => $event->getName(),
            'route'  => 'zfcadmin/eventlist/event/view',
            'params' => array('list' => $list->getSlug(), 'event' => $event->getId()),
            'active' => true,
            'pages'  => array(
                array(
                    'label'  => 'Update ' . $event->getName(),
                    'route'  => 'zfcadmin/eventlist/event/update',
                    'params' => array('list' => $list->getSlug(), 'event' => $event->getId()),
                    'active' => true,
                ),
            ),
        ));

        return array(
            'list'  => $list,
            'event' => $event,
            'form'  => $form,
        );
    }

    public function deleteAction()
    {
        if (!$this->getRequest()->isPost()) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $list    = $this->getList();
        $event   = $this->getEventEntity($list);
        $service = $this->getService();

        $service->delete($event);

        $this->flashMessenger()->addMessage('Event deleted successfully.');
        return $this->redirect()->toRoute('zfcadmin/eventlist', array(
            'list' => $list->getSlug(),
        ));
    }

    protected function getList()
    {
        $slug = $this->params('list');
        $repo = $this->getService()->getListRepository();
        $list = $repo->findOneBySlug($slug);

        if (null === $list) {
            throw new Exception\EventListNotFoundException(sprintf(
                'Event list with slug "%s" not found', $slug
            ));
        }

        return $list;
    }

    protected function getEventEntity(EventList $list, $create = false)
    {
        if (true === $create) {
            $class = $this->getOptions()->getEventEntityClass();
            $event = new $class;
            $event->setList($list);

            return $event;
        }

        $id    = $this->params('event');
        $event = $this->getEventRepository()->find($id);

        if (null === $event) {
            throw new Exception\EventNotFoundException(sprintf(
                'Event with id "%s" not found', $id
            ));
        } elseif ($event->getList()->getId() !== $list->getId()) {
            throw new Exception\EventNotFoundException(sprintf(
                'Event with id "%s" is not part of list %s', $id, $list->getSlug()
            ));
        }

        return $event;
    }

    protected function addPage(array $config = array())
    {
        $admin = $this->getServiceLocator()->get('admin_navigation');
        $found = false;

        // We need to query the page ourselves as
        // $admin->findOneByRoute('zfcadmin/eventlist')
        // does not load the page by reference

        foreach ($admin->getPages() as $page) {
            if ($page->getRoute() === 'zfcadmin/eventlist') {
                $found = true;
                break;
            }
        }

        if (!$found) {
            return;
        }

        $page->addPage($config);
    }

    protected function getService()
    {
        return $this->service;
    }

    protected function getForm()
    {
        return $this->form;
    }

    protected function getOptions()
    {
        return $this->options;
    }

    protected function getListRepository()
    {
        return $this->getService()->getListRepository();
    }

    protected function getEventRepository()
    {
        return $this->getService()->getEventRepository();
    }
}
