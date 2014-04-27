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
use Miliooo\Friends\TestHelpers\UserIdentifierTestHelper;
use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Test file for Miliooo\Friends\Entity\Relationship
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UserIdentifierInterface
     */
    private $follower;

    /**
     * @var UserIdentifierInterface
     */
    private $followed;

    /**
     * @var /DateTime
     */
    private $dateCreated;

    /**
     * The class under test.
     *
     * @var Relationship
     */
    private $relationship;

    public function setUp()
    {
        $this->follower = new UserIdentifierTestHelper('1');
        $this->followed = new UserIdentifierTestHelper('2');
        $this->dateCreated = new \DateTime('2013-10-10 00:00:00');
        $userRelationship = new UserRelationship($this->follower, $this->followed);
        $this->relationship = new Relationship($userRelationship, $this->dateCreated);
    }

    public function testGetters()
    {
        $userRelationship = new UserRelationship($this->follower, $this->followed);
        $relationship = new Relationship($userRelationship, $this->dateCreated);

        $this->assertEquals($this->follower, $this->relationship->getFollower());
        $this->assertEquals($this->followed, $this->relationship->getFollowed());
        $this->assertEquals($this->dateCreated, $relationship->getDateCreated());
    }

    public function testAttributes()
    {
        $this->assertClassHasAttribute('follower', 'Miliooo\Friends\Model\Relationship');
        $this->assertClassHasAttribute('followed', 'Miliooo\Friends\Model\Relationship');
        $this->assertClassHasAttribute('dateCreated', 'Miliooo\Friends\Model\Relationship');
    }
}
