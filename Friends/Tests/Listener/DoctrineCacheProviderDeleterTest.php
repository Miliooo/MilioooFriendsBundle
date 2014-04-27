<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Listener;

use Miliooo\Friends\Listener\DoctrineCacheProviderDeleter;
use Miliooo\Friends\Event\MilioooFriendsEvents;

/**
 * Test file for Miliooo\Friends\Listener\DoctrineCacheProviderDeleter
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DoctrineCacheProviderDeleterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_FrameWork_MockObject_MockObject
     */
    private $cache;

    /**
     * @var DoctrineCacheProviderDeleter
     */
    private $testObject;

    /**
     * @var \PHPUnit_FrameWork_MockObject_MockObject
     */
    private $follower;

    /**
     * @var \PHPUnit_FrameWork_MockObject_MockObject
     */
    private $followed;

    /**
     * @var \PHPUnit_FrameWork_MockObject_MockObject
     */
    private $event;

    /**
     * @var \PHPUnit_FrameWork_MockObject_MockObject
     */
    private $relationship;

    public function setUp()
    {
        $this->cache = $this->getMock('Doctrine\Common\Cache\Cache');
        $this->testObject = new DoctrineCacheProviderDeleter($this->cache);
        $this->follower = $this->getMock('Miliooo\Friends\User\UserIdentifierInterface');
        $this->followed = $this->getMock('Miliooo\Friends\User\UserIdentifierInterface');
        $this->event = $this->getMockBuilder('Miliooo\Friends\Event\RelationshipEvent')->disableOriginalConstructor()->getMock();
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->testObject);
    }

    public function testGetSubscribedEvents()
    {
        $result = [
            MilioooFriendsEvents::RELATIONSHIP_CREATED => 'onRelationshipCreated',
            MilioooFriendsEvents::RELATIONSHIP_REMOVED => 'onRelationshipRemoved'
        ];
        $this->assertEquals($result, $this->testObject->getSubscribedEvents());
    }

    public function testOnRelationshipCreated()
    {
        $this->event->expects($this->once())->method('getRelationship')->will($this->returnValue($this->relationship));
        $this->relationship->expects($this->once())->method('getFollower')->will($this->returnValue($this->follower));
        $this->relationship->expects($this->once())->method('getFollowed')->will($this->returnValue($this->followed));
        $this->testObject->onRelationshipCreated($this->event);
    }




}
