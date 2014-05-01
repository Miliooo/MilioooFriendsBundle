<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Command;

use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Class AbstractRelationshipCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class AbstractRelationshipCommand
{
    /**
     * @var UserRelationship
     */
    protected $userRelationship;

    /**
     * Sets the user relationship.
     *
     * @param UserRelationship $userRelationship
     */
    public function setUserRelationship(UserRelationship $userRelationship)
    {
        $this->userRelationship = $userRelationship;
    }

    /**
     * Returns the user relationship.
     *
     * @return UserRelationship
     */
    public function getUserRelationship()
    {
        return $this->userRelationship;
    }
}
