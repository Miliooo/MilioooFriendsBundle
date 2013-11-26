<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Exceptions;

use Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException;

/**
 * Class IdenticalFollowerFollowedExceptionTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class IdenticalFollowerFollowedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInstanceOf()
    {
        $this->assertInstanceOf('Miliooo\Friends\Exceptions\FriendException', new IdenticalFollowerFollowedException());
    }
}
