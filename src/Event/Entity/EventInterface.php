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

interface EventInterface
{
    /**
     * Getter for id
     *
     * @return mixed
     */
    public function getId();

    /**
     * Getter for name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Setter for name
     *
     * @param mixed $name Value to set
     * @return self
     */
    public function setName($name);

    /**
     * Getter for lead
     *
     * @return mixed
     */
    public function getLead();

    /**
     * Setter for lead
     *
     * @param mixed $lead Value to set
     * @return self
     */
    public function setLead($lead);

    /**
     * Getter for body
     *
     * @return mixed
     */
    public function getBody();

    /**
     * Setter for body
     *
     * @param mixed $body Value to set
     * @return self
     */
    public function setBody($body);

    /**
     * Getter for start
     *
     * @return mixed
     */
    public function getStartTimestamp();

    /**
     * Setter for start
     *
     * @param mixed $start Value to set
     * @return self
     */
    public function setStartTimestamp(DateTime $start);

    /**
     * Getter for end
     *
     * @return mixed
     */
    public function getEndTimestamp();

    /**
     * Setter for end
     *
     * @param mixed $end Value to set
     * @return self
     */
    public function setEndTimestamp(DateTime $end);


    /**
     * Getter for allDay
     *
     * @return mixed
     */
    public function getAllDay();

    /**
     * Setter for allDay
     *
     * @param mixed $allDay Value to set
     * @return self
     */
    public function setAllDay($allDay = true);

    /**
     * Getter for event list
     *
     * @return ListInterface
     */
    public function getList();

    /**
     * Setter for event list
     *
     * @param  ListInterface $list List this event belongs to
     * @return self
     */
    public function setList(ListInterface $list);

    /**
     * Getter for event category
     *
     * @return CategoryInterface
     */
    public function getCategory();

    /**
     * Setter for event category
     *
     * @param  CategoryInterface $category Category this event belongs to
     * @return self
     */
    public function setCategory(CategoryInterface $category);
}
