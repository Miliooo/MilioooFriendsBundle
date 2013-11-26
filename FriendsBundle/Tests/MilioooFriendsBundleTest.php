<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Tests;

use Miliooo\FriendsBundle\MilioooFriendsBundle;

/**
 * Class MilioooFriendsBundleTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class MilioooFriendsBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf('Symfony\Component\HttpKernel\Bundle\Bundle', new MilioooFriendsBundle());
    }
}
