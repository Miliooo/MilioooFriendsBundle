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
use Miliooo\Friends\User\UserIdentifierInterface;

/**
 * Class DeleteRelationshipCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteRelationshipCommand
{
    /**
     * @var UserRelationship
     */
    protected $userRelationship;

    /**
     * @var UserIdentifierInterface
     */
    protected $loggedInUser;

    /**
     * Sets the logged in user.
     *
     * @param UserIdentifierInterface $loggedInUser
     */
    public function setLoggedInUser(UserIdentifierInterface $loggedInUser)
    {
        $this->loggedInUser = $loggedInUser;
    }

    /**
     * Returns the logged in user.
     *
     * @return UserIdentifierInterface
     */
    public function getLoggedInUser()
    {
        return $this->loggedInUser;
    }

    /**
     * Sets the user relationship we want to delete.
     *
     * @param UserRelationship $userRelationship
     */
    public function setUserRelationship(UserRelationship $userRelationship)
    {
        $this->userRelationship = $userRelationship;
    }

    /**
     * Returns the user relationship we want to delete.
     *
     * @return UserRelationship
     */
    public function getUserRelationship()
    {
        return $this->userRelationship;
    }
}
