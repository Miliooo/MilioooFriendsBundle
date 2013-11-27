<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Creator;

use Miliooo\Friends\Creator\RelationshipCreator;
use Miliooo\Friends\ValueObjects\UserRelationship;
use Miliooo\Friends\TestHelpers\UserRelationshipTestHelper;
use Miliooo\Friends\User\UserRelationshipInterface;

/**
 * Class RelationshipCreatorTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RelationshipCreator
     */
    private $creator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationshipRepository;

    /**
     * @var string Fully Qualified Class Name for relationship model
     */
    private $fqcn;

    /**
     * @var UserRelationship
     */
    private $userRelationship;

    /**
     * @var \DateTime;
     */
    private $dateCreated;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    /**
     * @var UserRelationshipInterface
     */
    private $follower;

    /**
     * @var UserRelationshipInterface
     */
    private $followed;

    public function setUp()
    {
        $this->relationshipRepository = $this->getMock('Miliooo\Friends\Repository\RelationshipRepositoryInterface');
        $this->fqcn = 'Miliooo\FriendsBundle\Entity\Relationship';
        $this->creator = new RelationshipCreator($this->relationshipRepository, $this->fqcn);
        $this->follower = new UserRelationshipTestHelper('1');
        $this->followed = new UserRelationshipTestHelper('2');
        $this->userRelationship = new UserRelationship($this->follower, $this->followed);
        $this->dateCreated = new \DateTime('2013-10-10');
        $this->relationship = $this->getMockBuilder('Miliooo\FriendsBundle\Entity\Relationship')
            ->disableOriginalConstructor()->getMock();
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Creator\RelationshipCreatorInterface', $this->creator);
    }

    /**
     * @expectedException \Miliooo\Friends\Exceptions\RelationshipAlreadyExistsException
     */
    public function testCreateRelationshipThrowsExceptionWhenRelationshipAlreadyExists()
    {
        $this->expectsRelationshipExists();


        $this->creator->createRelationship($this->userRelationship, $this->dateCreated);
    }

    public function testCreateRelationshipCreatesRelationship()
    {
        $this->expectsNonExistingRelationship();
        $saveObject = new $this->fqcn($this->userRelationship, $this->dateCreated);
        $this->relationshipRepository->expects($this->once())->method('saveRelationship')->with($saveObject);

        $result = $this->creator->createRelationship($this->userRelationship, $this->dateCreated);

        $this->assertInstanceOf('Miliooo\Friends\Model\RelationshipInterface', $result);
        $this->assertEquals($this->follower, $result->getFollower());
        $this->assertEquals($this->followed, $result->getFollowed());
        $this->assertEquals($this->dateCreated, $result->getDateCreated());
    }

    protected function expectsRelationshipExists()
    {
        $this->relationshipRepository->expects($this->once())->method('findRelationship')
            ->with($this->userRelationship)
            ->will($this->returnValue($this->relationship));
    }

    protected function expectsNonExistingRelationship()
    {
        $this->relationshipRepository->expects($this->once())->method('findRelationship')
            ->with($this->userRelationship)
            ->will($this->returnValue(null));
    }
}
