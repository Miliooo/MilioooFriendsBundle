<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Tests\Controller;

use Miliooo\FriendsBundle\Controller\DeleteFriendsController;
use Miliooo\Friends\TestHelpers\UserRelationshipTestHelper;
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
    private $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $deleter;


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
        $this->repository = $this->getMock('Miliooo\Friends\Repository\RelationshipRepositoryInterface');
        $this->deleter = $this->getMock('Miliooo\Friends\Deleter\RelationshipDeleterSecureInterface');
        $this->controller = new DeleteFriendsController(
            $this->loggedInUserProvider,
            $this->transformer,
            $this->repository,
            $this->deleter
        );

        $this->loggedInUser = new UserRelationshipTestHelper('1');
        $this->followed = new UserRelationshipTestHelper('2');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
    }

    public function testDeleteFriendshipAction()
    {
        $this->expectsLoggedInUser();
        $this->expectsFollowedObject();
        $this->expectsRepositoryReturnsRelationship();
        $this->expectsDelete();
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

    protected function expectsRepositoryReturnsRelationship()
    {
        $userRelationship = new UserRelationship($this->loggedInUser, $this->followed);
        $this->repository->expects($this->once())->method('findRelationship')->with($userRelationship)
            ->will($this->returnValue($this->relationship));
    }

    protected function expectsDelete()
    {
        $this->deleter->expects($this->once())->method('deleteRelationship')
            ->with($this->loggedInUser, $this->relationship)
            ->will($this->returnValue($this->relationship));
    }
}
