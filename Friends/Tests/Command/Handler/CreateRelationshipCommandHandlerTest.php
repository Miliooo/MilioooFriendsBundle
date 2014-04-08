<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Command\Handler;

use Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandler;

/**
 * Class CreateRelationshipCommandHandlerTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateRelationshipCommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test.
     *
     * @var CreateRelationshipCommandHandler
     */
    private $handler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $creator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    public function setUp()
    {
        $this->creator = $this->getMock('Miliooo\Friends\Creator\RelationshipCreatorInterface');
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->handler = new CreateRelationshipCommandHandler($this->creator, $this->dispatcher);
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandlerInterface', $this->handler);
    }
}
