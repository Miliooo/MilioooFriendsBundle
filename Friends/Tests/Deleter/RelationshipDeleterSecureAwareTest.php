<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Tests\Deleter;

use Miliooo\Friends\Deleter\RelationshipDeleterSecureAware;

/**
 * Test file for Miliooo\Friends\Deleter\RelationshipDeleterSecureAware
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipDeleterSecureAwareTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var RelationshipDeleterSecureAware
     */
    private $deleterSecureAware;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $deleter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
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
        $this->specification = $this->getMock('Miliooo\Friends\Specifications\CanDeleteRelationshipSpecificationInterface');
        $this->deleter = $this->getMock('Miliooo\Friends\Deleter\RelationshipDeleterInterface');
        $this->deleterSecureAware = new RelationshipDeleterSecureAware($this->deleter, $this->specification);
        $this->user = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');
        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Deleter\RelationshipDeleterSecureInterface', $this->deleterSecureAware);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @expectedExceptionMessage Not enough rights to delete this relationship
     */
    public function testExceptionIsThrownWhenNotEnoughRightsToDelete()
    {
        $this->expectsSpecificationCallAndWillReturn(false);
        $this->deleter->expects($this->never())->method('deleteRelationship');
        $this->deleterSecureAware->deleteRelationship($this->user, $this->relationship);
    }

    public function testDeleteRelationshipWithEnoughRights()
    {
        $this->expectsSpecificationCallAndWillReturn(true);
        $this->deleter->expects($this->once())->method('deleteRelationship')
            ->with($this->relationship)
            ->will($this->returnValue($this->relationship));

        $result = $this->deleterSecureAware->deleteRelationship($this->user, $this->relationship);
        $this->assertSame($this->relationship, $result);
    }

    /**
     * @param boolean $boolean The return value of the specification
     */
    protected function expectsSpecificationCallAndWillReturn($boolean)
    {
        $this->specification->expects($this->once())->method('isSatisfiedBy')
            ->with($this->user, $this->relationship)
            ->will($this->returnValue($boolean));
    }
}
