<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Provider;

use Miliooo\Friends\Provider\UserRelationshipsProvider;

/**
 * Test file for Miliooo\Friends\Provider\UserRelationshipsProvider
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipsProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var UserRelationshipsProvider
     */
    private $provider;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $user;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $follower;

    public function setUp()
    {
        $this->repository = $this->getMock('Miliooo\Friends\Repository\RelationshipRepositoryInterface');
        $this->provider = new UserRelationshipsProvider($this->repository);

        $this->user = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
        $this->follower = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Provider\UserRelationshipsProviderInterface', $this->provider);
    }

    public function testGetFollowing()
    {
        $this->repository->expects($this->once())->method('getFollowing')
            ->with($this->user)
            ->will($this->returnValue([]));

        $this->repository->expects($this->once())->method('getFollowers')
            ->with($this->user)
            ->will($this->returnValue([$this->relationship]));

        $this->relationship->expects($this->once())->method('getFollower')
            ->will($this->returnValue($this->follower));

        $this->follower->expects($this->once())->method('getUserRelationshipId')->will($this->returnValue(2));

        $result = $this->provider->getUserRelationships($this->user);

        $this->assertEquals($result->getFollowers(), [2]);
        $this->assertEmpty($result->getFriends());
        $this->assertEmpty($result->getFollowing());

    }
}
