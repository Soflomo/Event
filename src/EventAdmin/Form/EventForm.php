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

namespace Soflomo\EventAdmin\Form;

use DateTime;
use Zend\InputFilter;
use Zend\Form\Form;

class EventForm extends Form implements
    InputFilter\InputFilterProviderInterface
{
    const DATE_TIME_FORMAT = 'Y-m-d h:i';

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->add(array(
            'name'    => 'name',
            'options' => array(
                'label' => 'Name'
            ),
        ));

        $this->add(array(
            'name'    => 'lead',
            'options' => array(
                'label' => 'Lead'
            ),
            'attributes' => array(
                'type'  => 'textarea',
            ),
        ));

        $this->add(array(
            'name'    => 'body',
            'options' => array(
                'label' => 'Body'
            ),
            'attributes' => array(
                'type'  => 'textarea',
            ),
        ));

        $this->add(array(
            'name'    => 'start_timestamp',
            'type'    => 'datetime',
            'options' => array(
                'label'  => 'From',
                'format' => self::DATE_TIME_FORMAT,
            )
        ));

        $this->add(array(
            'name'    => 'end_timestamp',
            'type'    => 'datetime',
            'options' => array(
                'label'  => 'Until',
                'format' => self::DATE_TIME_FORMAT,
            )
        ));
    }

    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
                'filters'  => array(
                    array('name' => 'stringtrim'),
                ),
            ),
            'lead'  => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'stringtrim'),
                    array('name' => 'htmlpurifier'),
                ),
            ),
            'body'  => array(
                'required' => false,
                'filters'  => array(
                    array('name' => 'stringtrim'),
                    array('name' => 'htmlpurifier'),
                ),
            ),
            'start_timestamp' => array(
                'required' => true,
            ),
            'end_timestamp' => array(
                'required' => true,
            ),
        );
    }

    public function isValid()
    {
        if (!parent::isValid()) {
            return false;
        }

        $data  = $this->getInputFilter()->getValues();
        $start = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $data['start_timestamp']);
        $end   = DateTime::createFromFormat(self::DATE_TIME_FORMAT, $data['end_timestamp']);

        if ($start > $end) {
            $this->get('end_timestamp')->setMessages(array(
                'Until must be later than the from timestamp'
            ));
            return false;
        }

        return true;
    }
}
