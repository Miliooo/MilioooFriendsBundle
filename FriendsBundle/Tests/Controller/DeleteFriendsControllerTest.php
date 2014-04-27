<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Tests\Controller;

use Miliooo\Friends\Command\DeleteRelationshipCommand;
use Miliooo\FriendsBundle\Controller\DeleteFriendsController;
use Miliooo\Friends\TestHelpers\UserIdentifierTestHelper;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Test file for Miliooo\FriendsBundle\Controller\DeleteFriendsController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteFriendsControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteFriendsController
     */
    private $controller;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $transformer;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $loggedInUserProvider;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $handler;

    private $loggedInUser;

    private $followed;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    public function setUp()
    {
        $this->loggedInUserProvider = $this->getMock('Miliooo\Friends\User\LoggedInUserProviderInterface');
        $this->transformer = $this->getMock('Miliooo\Friends\User\UserRelationshipTransformerInterface');
        $this->handler = $this->getMock('Miliooo\Friends\Command\Handler\DeleteRelationshipCommandHandlerInterface');

        $this->controller = new DeleteFriendsController(
            $this->loggedInUserProvider,
            $this->transformer,
            $this->handler
        );

        $this->loggedInUser = new UserIdentifierTestHelper('1');
        $this->followed = new UserIdentifierTestHelper('2');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
    }

    public function testDeleteFriendshipAction()
    {
        $this->expectsLoggedInUser();
        $this->expectsFollowedObject();
        $this->expectsHandlerCall();
        $this->controller->deleteRelationship(2);
    }

    protected function expectsLoggedInUser()
    {
        $this->loggedInUserProvider->expects($this->once())->method('getAuthenticatedUser')
            ->will($this->returnValue($this->loggedInUser));
    }

    protected function expectsFollowedObject()
    {
        $this->transformer->expects($this->once())->method('transformToObject')->with(2)
            ->will($this->returnValue($this->followed));
    }

    protected function expectsHandlerCall()
    {
        $userRelationship = new UserRelationship($this->loggedInUser, $this->followed);
        $command = new DeleteRelationshipCommand();
        $command->setLoggedInUser($this->loggedInUser);
        $command->setUserRelationship($userRelationship);
        $this->handler->expects($this->once())->method('handle')->with($command);
    }
}
