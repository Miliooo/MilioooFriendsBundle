<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Command\Handler;

use Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandler;
use Miliooo\Friends\Event\MilioooFriendsEvents;
use Miliooo\Friends\Event\RelationshipEvent;
use Miliooo\Friends\Exceptions\RelationshipAlreadyExistsException;

/**
 * Test file for Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandler
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateRelationshipCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var CreateRelationshipCommandHandler
     */
    private $handler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $creator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $createRelationshipCommand;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $userRelationship;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    public function setUp()
    {
        $this->creator = $this->getMock('Miliooo\Friends\Creator\RelationshipCreatorInterface');
        $this->createRelationshipCommand = $this->getMockBuilder('Miliooo\Friends\Command\CreateRelationshipCommand')
            ->disableOriginalConstructor()->getMock();

        $this->userRelationship = $this->getMockBuilder('Miliooo\Friends\ValueObjects\UserRelationship')
            ->disableOriginalConstructor()->getMock();

        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $this->dateCreated = new \DateTime('now');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
        $this->handler = new CreateRelationshipCommandHandler($this->creator, $this->dispatcher);
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandlerInterface', $this->handler);
    }

    public function testHandle()
    {
        $this->expectsCreateRelationshipCalled();
        $this->expectsEventDispatched();
        $this->handler->handle($this->createRelationshipCommand);
    }

    public function test_relationship_creator_throws_exception_no_call_to_dispatcher()
    {
        $this->expectsCommandGettersCalled();

        $this->creator->expects($this->once())->method('createRelationship')
            ->with($this->userRelationship, $this->dateCreated)
            ->will($this->throwException(new RelationshipAlreadyExistsException()));

        $this->dispatcher->expects($this->never())->method('dispatch');

        $this->handler->handle($this->createRelationshipCommand);
    }

    protected function expectsCreateRelationshipCalled()
    {
        $this->expectsCommandGettersCalled();

        $this->creator->expects($this->once())->method('createRelationship')
            ->with($this->userRelationship, $this->dateCreated)
            ->will($this->returnValue($this->relationship));
    }

    protected function expectsEventDispatched()
    {
        $event = new RelationshipEvent($this->relationship);
        $this->dispatcher->expects($this->once())->method('dispatch')
            ->with(MilioooFriendsEvents::RELATIONSHIP_CREATED, $event);
    }

    protected function expectsCommandGettersCalled()
    {
        $this->createRelationshipCommand->expects($this->once())->method('getUserRelationship')
            ->will($this->returnValue($this->userRelationship));
        $this->createRelationshipCommand->expects($this->once())->method('getDateCreated')
            ->will($this->returnValue($this->dateCreated));
    }
}
