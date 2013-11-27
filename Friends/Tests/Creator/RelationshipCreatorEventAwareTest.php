<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Creator;

use Miliooo\Friends\Creator\RelationshipCreatorEventAware;
use Miliooo\Friends\Event\MilioooFriendsEvents;
use Miliooo\Friends\Event\NewRelationshipEvent;

/**
 * Test file for Miliooo\Friends\Creator\RelationshipCreatorEventAware
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipCreatorEventAwareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var RelationshipCreatorEventAware
     */
    private $creatorEventAware;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $creator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $userRelationship;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;


    public function setUp()
    {
        $this->creator = $this->getMock('Miliooo\Friends\Creator\RelationshipCreatorInterface');
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->creatorEventAware = new RelationshipCreatorEventAware($this->creator, $this->dispatcher);

        $this->userRelationship = $this->getMockBuilder('Miliooo\Friends\ValueObjects\UserRelationship')
            ->disableOriginalConstructor()
            ->getMock();
        $this->dateCreated = new \DateTime('2013-10-10');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Creator\RelationshipCreatorInterface', $this->creatorEventAware);
    }

    public function testCreateRelationshipDispatchesWhenEventCreated()
    {
        $this->creator->expects($this->once())->method('createRelationship')
            ->with($this->userRelationship, $this->dateCreated)
            ->will($this->returnValue($this->relationship));

        $event = new NewRelationshipEvent($this->relationship);

        $this->dispatcher->expects($this->once())->method('dispatch')
            ->with(MilioooFriendsEvents::RELATIONSHIP_CREATED, $event);

        $result = $this->creatorEventAware->createRelationship($this->userRelationship, $this->dateCreated);

        $this->assertSame($this->relationship, $result);
    }
}
