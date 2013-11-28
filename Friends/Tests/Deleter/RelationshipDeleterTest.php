<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Tests\Deleter;

use Miliooo\Friends\Deleter\RelationshipDeleter;

/**
 * Test file for Miliooo\Friends\Deleter\RelationshipDeleter
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipDeleterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var RelationshipDeleter
     */
    private $deleter;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $relationship;

    public function setUp()
    {
        $this->repository = $this->getMock('Miliooo\Friends\Repository\RelationshipRepositoryInterface');
        $this->deleter = new RelationshipDeleter($this->repository);

        $this->relationship = $this->getMock('Miliooo\Friends\Model\RelationshipInterface');
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Deleter\RelationshipDeleterInterface', $this->deleter);
    }

    public function testDeleteRelationship()
    {
        $this->repository->expects($this->once())->method('deleteRelationship')
            ->with($this->relationship);

        $this->deleter->deleteRelationship($this->relationship);
    }
}
