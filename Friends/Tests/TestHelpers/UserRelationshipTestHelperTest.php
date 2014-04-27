<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\TestHelpers;

use Miliooo\Friends\TestHelpers\UserIdentifierTestHelper;

/**
 * Test file for Miliooo\Friends\TestHelpers\UserIdentifierTestHelper
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipTestHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUserRelationshipId()
    {
        $object = new UserIdentifierTestHelper('5');
        $this->assertEquals(5, $object->getIdentifierId());
    }
}
