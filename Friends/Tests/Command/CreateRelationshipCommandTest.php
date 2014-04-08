<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Command;

use Miliooo\Friends\Command\CreateRelationshipCommand;
use Miliooo\Friends\ValueObjects\UserRelationship;

class CreateRelationshipCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateRelationshipCommand
     */
    private $command;

    public function setUp()
    {
        $this->command = new CreateRelationshipCommand();
    }

    public function test_date_created()
    {
        $created = new \DateTime('2000-1-1');
        $this->command->setDateCreated($created);
        $this->assertSame($created, $this->command->getDateCreated());
    }

    public function test_user_relationship()
    {
        $userRelationship = $this->getMockBuilder('Miliooo\Friends\ValueObjects\UserRelationship')
            ->disableOriginalConstructor()->getMock();

        $this->command->setUserRelationship($userRelationship);
        $this->assertSame($userRelationship, $this->command->getUserRelationship());
    }

}
