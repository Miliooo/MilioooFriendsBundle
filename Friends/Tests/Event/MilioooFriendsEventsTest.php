<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Tests\Event;

use Miliooo\Friends\Event\MilioooFriendsEvents;

/**
 * Test file for Miliooo\Friends\Event\MilioooFriendsEvents
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class MilioooFriendsEventsTest extends \PHPUnit_Framework_TestCase
{
    public function testConstants()
    {
        $this->assertEquals('miliooo_friends.relationship_created', MilioooFriendsEvents::RELATIONSHIP_CREATED);
    }

}
