<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Exceptions;

use Miliooo\Friends\Exceptions\FriendException;

/**
 * Test file for Miliooo\Friends\Exceptions\FriendException
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class FriendExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf('Exception', new FriendException());
    }
}
