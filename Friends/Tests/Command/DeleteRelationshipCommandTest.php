<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Command;

use Miliooo\Friends\Command\DeleteRelationshipCommand;

/**
 * Test file for Miliooo\Friends\Command\DeleteRelationshipCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteRelationshipCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteRelationshipCommand
     */
    private $command;

    public function setUp()
    {
        $this->command = new DeleteRelationshipCommand();
    }

    public function test_userRelationship()
    {
        $userRelationship = $this->getMockBuilder('Miliooo\Friends\ValueObjects\UserRelationship')
            ->disableOriginalConstructor()->getMock();

        $this->command->setUserRelationship($userRelationship);
        $this->assertSame($userRelationship, $this->command->getUserRelationship());
    }

    public function test_loggedInUser()
    {
        $user = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');

        $this->command->setLoggedInUser($user);
        $this->assertSame($user, $this->command->getLoggedInUser());
    }
}
