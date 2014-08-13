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

namespace Soflomo\Event\Options;

use DateInterval;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**#@+
     * @var string
     */
    protected $listEntityClass;
    protected $categoryEntityClass;
    protected $eventEntityClass;

    /**#@+
     * @var string
     */
    protected $upcomingRange;
    protected $pastRange;

    /**#@+
     * @var int
     */
    protected $upcomingLimit;
    protected $pastLimit;
    protected $adminListingLimit;

    /**
     * Getter for listEntityClass
     *
     * @return mixed
     */
    public function getListEntityClass()
    {
        return $this->listEntityClass;
    }

    /**
     * Setter for listEntityClass
     *
     * @param mixed $listEntityClass Value to set
     * @return self
     */
    public function setListEntityClass($listEntityClass)
    {
        $this->listEntityClass = $listEntityClass;
        return $this;
    }

    /**
     * Getter for categoryEntityClass
     *
     * @return mixed
     */
    public function getCategoryEntityClass()
    {
        return $this->categoryEntityClass;
    }

    /**
     * Setter for categoryEntityClass
     *
     * @param mixed $categoryEntityClass Value to set
     * @return self
     */
    public function setCategoryEntityClass($categoryEntityClass)
    {
        $this->categoryEntityClass = $categoryEntityClass;
        return $this;
    }

    /**
     * Getter for eventEntityClass
     *
     * @return mixed
     */
    public function getEventEntityClass()
    {
        return $this->eventEntityClass;
    }

    /**
     * Setter for eventEntityClass
     *
     * @param mixed $eventEntityClass Value to set
     * @return self
     */
    public function setEventEntityClass($eventEntityClass)
    {
        $this->eventEntityClass = $eventEntityClass;
        return $this;
    }

    /**
     * Getter for upcomingRange
     *
     * @return mixed
     */
    public function getUpcomingRange()
    {
        return $this->upcomingRange;
    }

    /**
     * Setter for upcomingRange
     *
     * @param mixed $upcomingRange Value to set
     * @return self
     */
    public function setUpcomingRange($upcomingRange)
    {
        $this->upcomingRange = new DateInterval($upcomingRange);
        return $this;
    }

    /**
     * Getter for pastRange
     *
     * @return mixed
     */
    public function getPastRange()
    {
        return $this->pastRange;
    }

    /**
     * Setter for pastRange
     *
     * @param mixed $pastRange Value to set
     * @return self
     */
    public function setPastRange($pastRange)
    {
        $this->pastRange = new DateInterval($pastRange);
        return $this;
    }

    /**
     * Getter for upcomingLimit
     *
     * @return mixed
     */
    public function getUpcomingLimit()
    {
        return $this->upcomingLimit;
    }

    /**
     * Setter for upcomingLimit
     *
     * @param mixed $upcomingLimit Value to set
     * @return self
     */
    public function setUpcomingLimit($upcomingLimit)
    {
        $this->upcomingLimit = $upcomingLimit;
        return $this;
    }

    /**
     * Getter for pastLimit
     *
     * @return mixed
     */
    public function getPastLimit()
    {
        return $this->pastLimit;
    }

    /**
     * Setter for pastLimit
     *
     * @param mixed $pastLimit Value to set
     * @return self
     */
    public function setPastLimit($pastLimit)
    {
        $this->pastLimit = $pastLimit;
        return $this;
    }

    /**
     * Getter for adminListingLimit
     *
     * @return mixed
     */
    public function getAdminListingLimit()
    {
        return $this->adminListingLimit;
    }

    /**
     * Setter for adminListingLimit
     *
     * @param mixed $adminListingLimit Value to set
     * @return self
     */
    public function setAdminListingLimit($adminListingLimit)
    {
        $this->adminListingLimit = $adminListingLimit;
        return $this;
    }

}
