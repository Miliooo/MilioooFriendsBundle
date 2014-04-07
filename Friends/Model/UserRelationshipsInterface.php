<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/
namespace Miliooo\Friends\Model;

use Miliooo\Friends\User\UserRelationshipInterface;


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
     * @return array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    public function getFollowers();

    /**
     * Checks if the owner is following the given user.
     *
     * This can be used to determinate which action to take, follow or no longer follow a given user.
     *
     * @param UserRelationshipInterface $user The user for whom we check if the owner is following him
     *
     * @return boolean True if the owner is following this user, false otherwise.
     */
    public function isFollowing(UserRelationshipInterface $user);

    /**
     * Gets whom the owner is following.
     *
     * @return array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    public function getFollowing();

    /**
     * Gets the friends of the owner.
     *
     * @return array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    public function getFriends();
}
