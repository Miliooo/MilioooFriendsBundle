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
class UserRelationships
{
    /**
     * @var \Miliooo\Friends\User\UserRelationshipInterface
     */
    protected $owner;

    /**
     * @var array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    protected $friends;

    /**
     * @var array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    protected $followers;

    /**
     * @var array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    protected $following;

    /**
     * @param UserRelationshipInterface   $owner     The user for whom we populate the relationships data
     * @param UserRelationshipInterface[] $friends   The friends from the user
     * @param UserRelationshipInterface[] $followers The people that follow the user
     * @param UserRelationshipInterface[] $following The people that are following the user
     */
    public function __construct(UserRelationshipInterface $owner, array $friends, array $followers, array $following)
    {
        $this->owner = $owner;
        $this->friends = $friends;
        $this->followers = $followers;
        $this->following = $following;
    }

    /**
     * Checks if the owner is following the given user.
     *
     * This can be used to determinate which action to take, follow or no longer follow a given user.
     *
     * @param UserRelationshipInterface $user The user for whom we check if the owner is following him
     *
     * @return boolean True if the owner is following this user, false otherwise.
     */
    public function isFollowing(UserRelationshipInterface $user)
    {
        if ($this->isOwnerFriendsWithOrFollowingUser($user)) {
            return true;
        }

        return false;
    }

    /**
     * Gets the friends of the owner.
     *
     * @return array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Gets the followers of the owner.
     *
     * @return array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * Gets whom the owner is following.
     *
     * @return array|\Miliooo\Friends\User\UserRelationshipInterface[]
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * Checks if the owner is friends with or follows the given user.
     *
     * @param UserRelationshipInterface $user The user for whom we check if the owner is following or friends with him
     *
     * @return boolean True if there is a relationship, false otherwise
     */
    protected function isOwnerFriendsWithOrFollowingUser(UserRelationshipInterface $user)
    {
        if (in_array($user, $this->friends) || in_array($user, $this->following)) {
            return true;
        }

        return false;
    }
}
