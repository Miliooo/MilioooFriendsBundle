<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\TestHelpers;

use Miliooo\Friends\User\UserRelationshipInterface;

/**
 * Helper for the UserRelationshipInterface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipTestHelper implements UserRelationshipInterface
{
    /**
     * @var mixed
     */
    private $userRelationshipId;

    /**
     * Constructor.
     *
     * @param string $userRelationshipId
     */
    public function __construct($userRelationshipId)
    {
        $this->userRelationshipId = $userRelationshipId;
    }

    /**
     * Gets an unique identifier for the participant
     *
     * In most cases should be the id of the user but it can be anything
     * that uniquely represents a participant
     *
     * @return string The unique identifier
     */
    public function getUserRelationshipId()
    {
        return $this->userRelationshipId;
    }
}
