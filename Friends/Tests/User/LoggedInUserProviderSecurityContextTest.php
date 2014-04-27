<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\User;

use Miliooo\Friends\User\LoggedInUserProviderSecurityContext;
use Miliooo\Friends\TestHelpers\UserIdentifierTestHelper;
use Miliooo\Friends\User\UserIdentifierInterface;

/**
 * Test file for Miliooo\Friends\User\LoggedInUserProviderSecurityContext
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class LoggedInUserProviderSecurityContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The class under test
     *
     * @var LoggedInUserProviderSecurityContext
     */
    private $provider;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $securityContext;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $securityToken;

    /**
     * @var UserIdentifierInterface
     */
    private $loggedInUser;

    public function setUp()
    {
        $this->securityContext = $this->getMock('Symfony\Component\Security\Core\SecurityContextInterface');
        $this->securityToken = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $this->loggedInUser = new UserIdentifierTestHelper('1');
        $this->provider = new LoggedInUserProviderSecurityContext($this->securityContext);
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\User\LoggedInUserProviderInterface', $this->provider);
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @expectedExceptionMessage You must be logged in with a UserIdentifierInterface
     */
    public function testGetAuthenticatedUserTokenReturnsString()
    {
        $this->expectsToken();
        $this->securityToken->expects($this->once())->method('getUser')->will($this->returnValue('anon'));
        $this->provider->getAuthenticatedUser();
    }

    /**
     * @expectedException \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @expectedExceptionMessage You must be logged in with a UserIdentifierInterface
     */
    public function testGetAuthenticatedUserReturnsObjectNotInstanceParticipantInterface()
    {
        $this->expectsToken();
        $obj = new \stdClass;
        $this->securityToken->expects($this->once())->method('getUser')->will($this->returnValue($obj));
        $this->provider->getAuthenticatedUser();
    }

    public function testGetAuthenticatedUserReturnsUser()
    {
        $this->expectsToken();
        $this->expectsLoggedInUser();
        $this->assertEquals($this->loggedInUser, $this->provider->getAuthenticatedUser());
    }

    protected function expectsToken()
    {
        $this->securityContext->expects($this->once())->method('getToken')
            ->will($this->returnValue($this->securityToken));
    }

    protected function expectsLoggedInUser()
    {
        $this->securityToken->expects($this->once())->method('getUser')
            ->will($this->returnValue($this->loggedInUser));
    }
}
