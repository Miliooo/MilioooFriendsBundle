<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Specifications;

use Miliooo\Friends\Specifications\CanDeleteRelationshipSpecification;

/**
 * Test file for Miliooo\Friends\Specifications\CanDeleteRelationshipSpecification
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CanDeleteRelationshipSpecificationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Class under test.
     *
     * @var CanDeleteRelationshipSpecification
     */
    private $specification;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $user;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    public function setUp()
    {
        $this->user = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
        $this->specification = new CanDeleteRelationshipSpecification();
    }

    public function testInterface()
    {
        $this->assertInstanceOf(
            'Miliooo\Friends\Specifications\CanDeleteRelationshipSpecificationInterface',
            $this->specification
        );
    }

    public function testIsSatisfiedByReturnsTrue()
    {
        $this->user->expects($this->any())->method('getUserRelationshipId')->will($this->returnValue(1));
        $this->relationship->expects($this->once())->method('getFollower')->will($this->returnValue($this->user));

        $this->assertTrue($this->specification->isSatisfiedBy($this->user, $this->relationship));
    }

    public function testIsSatisfiedByReturnsFalse()
    {
        $follower = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');
        $follower->expects($this->once())->method('getUserRelationshipId')->will($this->returnValue(2));

        $this->user->expects($this->once())->method('getUserRelationshipId')->will($this->returnValue(1));
        $this->relationship->expects($this->once())->method('getFollower')->will($this->returnValue($follower));

        $this->assertFalse($this->specification->isSatisfiedBy($this->user, $this->relationship));
    }
}
