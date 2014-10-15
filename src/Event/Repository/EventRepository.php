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

namespace Soflomo\Event\Repository;

use DateTime;
use DateInterval;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

use Doctrine\ORM\Tools\Pagination\Paginator               as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Zend\Paginator\Paginator;

use Soflomo\Event\Entity\EventList;

class EventRepository extends EntityRepository
{
    public function findEvent(EventList $list, $id)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.list = :list')
           ->andWhere('e.id = :id')
           ->setParameter('list', $list)
           ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findUpcoming(EventList $list, DateInterval $range, $limit)
    {
        return $this->getUpcomingQuery($list, $range, $limit)->getResult();
    }

    public function findPast(EventList $list, DateInterval $range, $limit)
    {
        return $this->getPastQuery($list, $range, $limit)->getResult();
    }

    public function getUpcomingPaginator(EventList $list, $page, $limit)
    {
        $query     = $this->getUpcomingQuery($list);
        $paginator = $this->getPaginator($query);
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage($limit);

        return $paginator;
    }

    public function getPastPaginator(EventList $list, $page, $limit)
    {
        $query     = $this->getPastQuery($list);
        $paginator = $this->getPaginator($query);
        $paginator->setCurrentPageNumber($page)
                  ->setItemCountPerPage($limit);

        return $paginator;
    }

    public function getPaginator(Query $query)
    {
        $paginator = new DoctrinePaginator($query);
        $adapter   = new PaginatorAdapter($paginator);

        return new Paginator($adapter);
    }

    protected function getUpcomingQuery(EventList $list, DateInterval $range = null, $limit = null)
    {
        $start = new DateTime;
        $qb    = $this->createQueryBuilder('e');
        $qb->andWhere('e.list = :list')
           ->andWhere('e.start >= :start')
           ->setParameter('list', $list)
           ->setParameter('start', $start)
           ->orderBy('e.start', 'ASC');

        if ($range) {
            $end   = clone $start;
            $end->add($range)->setTime(23, 59, 59);

            $qb->andWhere('e.end <= :end')
               ->setParameter('end', $end);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery();
    }

    protected function getPastQuery(EventList $list, DateInterval $range = null, $limit = null)
    {
        $end = new DateTime;
        $qb  = $this->createQueryBuilder('e');
        $qb->andWhere('e.list = :list')
           ->andWhere('e.end <= :end')
           ->setParameter('list', $list)
           ->setParameter('end', $end)
           ->orderBy('e.start', 'DESC');

        if ($range) {
            $start = clone $end;
            $start->sub($range)->setTime(0, 0, 0);

            $qb->andWhere('e.start >= :start')
               ->setParameter('start', $start);
        }

        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery();
    }
}
