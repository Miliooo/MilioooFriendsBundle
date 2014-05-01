<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Model;

use Miliooo\Friends\Model\UserRelationships;

/**
 * Test file for Miliooo\Friends\Model\UserRelationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserRelationships
     */
    private $relationships;

    public function setUp()
    {
        $friends = [20 => 1, 10 => 1];
        $following =[20 => 1, 10 => 1, 7 => 1, 9 => 1, 100 => 1];
        $followers = [20 => 1, 10 => 1, 5 => 1];

        $this->relationships = new UserRelationships(5, $friends, $followers, $following);
    }

    public function test_getFollowers()
    {
        $this->assertTrue(in_array(5, $this->relationships->getFollowers()));
        $this->assertCount(3, $this->relationships->getFollowers());
    }

    public function test_isFollowing()
    {
        $this->assertTrue($this->relationships->isFollowing(100));
        $this->assertFalse($this->relationships->isFollowing(5));
    }

    public function test_getFriends()
    {
        $this->assertTrue(in_array(20, $this->relationships->getFriends()));
        $this->assertFalse(in_array(100, $this->relationships->getFriends()));
    }

    public function test_getFollowing()
    {
        $this->assertTrue(in_array(100, $this->relationships->getFollowing()));
    }

    public function test_getAllIdentifierIds()
    {
        $expectedResult = [20, 10, 7, 9, 100, 5];
        $result = $this->relationships->getAllIdentifierIds();

        $this->assertCount(6, $result);
        $this->assertEmpty(array_diff($expectedResult, $result));
        $this->assertEmpty(array_diff($result, $expectedResult));
    }
}
