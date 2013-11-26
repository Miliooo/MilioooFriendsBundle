<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\TestHelpers;

use Miliooo\Friends\TestHelpers\UserRelationshipTestHelper;

/**
 * Test file for Miliooo\Friends\TestHelpers\UserRelationshipTestHelper
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipTestHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUserRelationshipId()
    {
        $object = new UserRelationshipTestHelper('5');
        $this->assertEquals(5, $object->getUserRelationshipId());
    }
}
