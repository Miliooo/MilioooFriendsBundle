<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Tests\Entity;

use Miliooo\FriendsBundle\Entity\Relationship;
use Miliooo\Friends\TestHelpers\UserRelationshipTestHelper;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Test file for Miliooo\FriendsBundle\Entity\Relationship
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var Relationship
     */
    private $relationship;

    public function setUp()
    {
        $follower = new UserRelationshipTestHelper('1');
        $followed = new UserRelationshipTestHelper('2');
        $userRelationship = new UserRelationship($follower, $followed);
        $dateCreated = new \DateTime('now');
        $this->relationship = new Relationship($userRelationship, $dateCreated);
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf('Miliooo\Friends\Model\Relationship', $this->relationship);
    }

    public function testId()
    {
        $this->assertClassHasAttribute('id', 'Miliooo\FriendsBundle\Entity\Relationship');
    }
}
