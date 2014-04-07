<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Tests\Event;

use Miliooo\Friends\Event\RelationshipEvent;

/**
 * Test file for Miliooo\Friends\Event\NewRelationshipEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class NewRelationshipEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    /**
     * @var RelationshipEvent
     */
    private $event;

    public function setUp()
    {
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
        $this->event = new RelationshipEvent($this->relationship);
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $this->event);
    }

    public function testGetRelationship()
    {
        $this->assertSame($this->relationship, $this->event->getRelationship());
    }
}
