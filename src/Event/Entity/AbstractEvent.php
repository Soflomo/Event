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

namespace Soflomo\Event\Entity;

use DateTime;

abstract class AbstractEvent implements EventInterface
{
    /**
     * @var int
     */
    protected $id;

    /**#@+
     * @var string
     */
    protected $name;
    protected $lead;
    protected $body;

    /**#@+
     * @var DateTime
     */
    protected $start;
    protected $end;

    /**
     * @var bool
     */
    protected $allDay = false;

    /**
     * @var ListInterface
     */
    protected $list;

    /**
     * @var CategoryInterface
     */
    protected $category;

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * {@inheritDoc}
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
        return $this;
    }

    /**
     * {inheritDoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {inheritDoc}
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * {inheritDoc}
     */
    public function getStartTimestamp()
    {
        return $this->start;
    }

    /**
     * {inheritDoc}
     */
    public function setStartTimestamp(DateTime $start)
    {
        $this->start = $start;
        return $this;
    }

    /**
     * {inheritDoc}
     */
    public function getEndTimestamp()
    {
        return $this->end;
    }

    /**
     * {inheritDoc}
     */
    public function setEndTimestamp(DateTime $end)
    {
        $this->end = $end;
        return $this;
    }

    /**
     * {inheritDoc}
     */
    public function getAllDay()
    {
        return $this->allDay;
    }

    /**
     * {inheritDoc}
     */
    public function setAllDay($allDay = true)
    {
        $this->allDay = (bool) $allDay;
        return $this;
    }

    /**
     * {inheritDoc}
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * {inheritDoc}
     */
    public function setList(ListInterface $list)
    {
        $this->list = $list;
        return $this;
    }

    /**
     * {inheritDoc}
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * {inheritDoc}
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
        return $this;
    }
}
