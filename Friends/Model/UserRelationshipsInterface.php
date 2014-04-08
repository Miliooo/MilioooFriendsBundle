<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Model;

/**
 * This class is responsible for providing common functions for checking relationships for a given user.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface UserRelationshipsInterface
{
    /**
     * Gets the followers of the owner.
     *
     * @return Array with UserRelationshipIds for which the owner is friends.
     */
    public function getFollowers();

    /**
     * Checks if the owner is followingIds the given user.
     *
     * This can be used to determinate which action to take, follow or no longer follow a given user.
     *
     * @param string $userRelationshipId The user for whom we check if the owner is following him
     *
     * @return boolean True if the owner is following this user, false otherwise.
     */
    public function isFollowing($userRelationshipId);

    /**
     * Gets whom the owner is following.
     *
     * @return array Array with UserRelationshipIds for which the owner is following.
     */
    public function getFollowing();

    /**
     * Gets the friends of the owner.
     *
     * @return Array with UserRelationshipIds for which the owner is friends.
     */
    public function getFriends();
}
