<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Tests\Controller;

use Miliooo\FriendsBundle\Controller\AddFriendsController;
use Miliooo\Friends\TestHelpers\UserIdentifierTestHelper;
use Miliooo\Friends\Command\CreateRelationshipCommand;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Test file for Miliooo\FriendsBundle\Controller\AddFriendsController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AddFriendsControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Class under test.
     *
     * @var AddFriendsController
     */
    private $controller;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $handler;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $loggedInUserProvider;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $transformer;

    private $loggedInUser;

    private $followed;

    public function setUp()
    {
        $this->loggedInUserProvider = $this->getMock('Miliooo\Friends\User\LoggedInUserProviderInterface');
        $this->handler = $this->getMock('Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandlerInterface');
        $this->transformer = $this->getMock('Miliooo\Friends\User\UserRelationshipTransformerInterface');
        $this->controller = new AddFriendsController(
            $this->handler,
            $this->loggedInUserProvider,
            $this->transformer
        );

        $this->loggedInUser = new UserIdentifierTestHelper('1');
        $this->followed = new UserIdentifierTestHelper('2');
    }

    public function testAddFriendsAction()
    {
        $this->expectsLoggedInUser();
        $this->expectsTransformedToObject();
        $this->expectsRelationshipCreated();

        $result = $this->controller->addFriendsAction('2');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $result);

        $data = $this->controller->getData();
        $this->assertEquals($data['user_relationship_id'], 2);
        $this->assertEquals($data['action'], 'follow');
        $this->assertArrayNotHasKey('error', $data);
    }

    protected function expectsLoggedInUser()
    {
        $this->loggedInUserProvider->expects($this->once())->method('getAuthenticatedUser')
            ->will($this->returnValue($this->loggedInUser));
    }

    protected function expectsTransformedToObject()
    {
        $this->transformer->expects($this->once())->method('transformToObject')->with('2')
            ->will($this->returnValue($this->followed));
    }

    protected function expectsRelationshipCreated()
    {
        $userRelationship = new UserRelationship($this->loggedInUser, $this->followed);
        $command = new CreateRelationshipCommand();
        $command->setDateCreated(new \DateTime('now'));
        $command->setUserRelationship($userRelationship);

        $this->handler->expects($this->once())->method('handle')->with($command);
    }
}
