<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Tests\ValueObjects;

use Miliooo\Friends\ValueObjects\UserRelationship;
use Miliooo\Friends\TestHelpers\UserRelationshipTestHelper;

/**
 * Test file for Miliooo\Friends\ValueObjects\UserRelationship
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException
     */
    public function testIdenticalFollowerFollowedThrowsException()
    {
        $follower = new UserRelationshipTestHelper('1');
        $followed = new UserRelationshipTestHelper('1');
        new UserRelationship($follower, $followed);
    }

    public function testValidUserRelationship()
    {
        $follower = new UserRelationshipTestHelper('1');
        $followed = new UserRelationshipTestHelper('2');
        $userRelationship = new UserRelationship($follower, $followed);

        $this->assertEquals($follower, $userRelationship->getFollower());
        $this->assertEquals($followed, $userRelationship->getFollowed());
    }

}
