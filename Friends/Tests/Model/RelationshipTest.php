<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Model;

use Miliooo\Friends\Model\Relationship;
use Miliooo\Friends\TestHelpers\UserRelationshipTestHelper;
use Miliooo\Friends\User\UserRelationshipInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Test file for Miliooo\Friends\Model\Relationship
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserRelationshipInterface
     */
    private $follower;

    /**
     * @var UserRelationshipInterface
     */
    private $followed;

    /**
     * @var /DateTime
     */
    private $dateCreated;

    public function setUp()
    {
        $this->follower = new UserRelationshipTestHelper('1');
        $this->followed = new UserRelationshipTestHelper('2');
        $this->dateCreated = new \DateTime('2013-10-10 00:00:00');
    }

    public function testGetters()
    {
        $userRelationship = new UserRelationship($this->follower, $this->followed);
        $relationship = new Relationship($userRelationship, $this->dateCreated);

        $this->assertEquals($this->follower->getUserRelationshipId(), $relationship->getFollower()->getUserRelationshipId());
        $this->assertEquals($this->followed->getUserRelationshipId(), $relationship->getFollowed()->getUserRelationshipId());
        $this->assertEquals($this->dateCreated, $relationship->getDateCreated());
    }
}
