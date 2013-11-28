<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Provider;

use Miliooo\Friends\User\UserRelationshipInterface;

/**
 * Provides the relationships for a single user
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface UserRelationshipsProviderInterface
{
    /**
     * Gets the users who the person is following.
     *
     * @param UserRelationshipInterface $user
     *
     * @return UserRelationshipInterface[] An array with the users who the user is following.
     */
    public function getFollowing(UserRelationshipInterface $user);

    /**
     * Gets the users who follow the given person.
     *
     * @param UserRelationshipInterface $user
     *
     * @return UserRelationshipInterface[] An array with users who follow the given user.
     */
    public function getFollowers(UserRelationshipInterface $user);

    /**
     * @param UserRelationshipInterface $user
     *
     * @return UserRelationshipInterface[] An array with users who follows the person and who the person also follows
     */
    public function getFriends(UserRelationshipInterface $user);
}
