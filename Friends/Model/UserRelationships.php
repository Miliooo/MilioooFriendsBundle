<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Model;

use Miliooo\Friends\User\UserIdentifierInterface;

/**
 * This class is responsible for providing common functions for checking relationships for a given user.
 *
 * We use the getRelationshipIds from this class and not the user relationship interface because we want to be able
 * to easily serialize and unserialize this class.
 *
 * Since all the checks for a given relationship between two users only depends on the userRelationshipId there is no need
 * to serialize whole user objects.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationships implements UserRelationshipsInterface
{
    /**
     * @var UserIdentifierInterface
     */
    protected $owner;

    /**
     * @var array
     */
    protected $friends;

    /**
     * @var array
     */
    protected $followers;

    /**
     * @var array
     */
    protected $following;

    /**
     * Constructor.
     *
     * @param string $ownerId      The UserRelationshipId from the owner
     * @param []     $friendIds    Array with friend UserRelationshipIds where the keys are the userRelationshipIds
     * @param []     $followerIds  Array with follower UserRelationshipIds where the keys are the userRelationshipIds
     * @param []     $followingIds Array with following UserRelationshipIds where the keys are the userRelationshipIds
     */
    public function __construct($ownerId, array $friendIds, array $followerIds, array $followingIds)
    {
        $this->owner = $ownerId;
        $this->friends = $friendIds;
        $this->followers = $followerIds;
        $this->following = $followingIds;
    }

    /**
     * {@inheritdoc}
     */
    public function isFollowing($userRelationshipId)
    {
        if ($this->isOwnerFriendsWithOrFollowingUser($userRelationshipId)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getFriends()
    {
        return array_keys($this->friends);
    }

    /**
     * {@inheritdoc}
     */
    public function getFollowers()
    {
        return array_keys($this->followers);
    }

    /**
     * {@inheritdoc}
     */
    public function getFollowing()
    {
        return array_keys($this->following);
    }

    /**
     * Checks if the owner is friendIds with or follows the given user.
     *
     * @param string $userRelationshipId The user for whom we check if the owner is following or friend with him
     *
     * @return boolean True if there is a relationship, false otherwise
     */
    protected function isOwnerFriendsWithOrFollowingUser($userRelationshipId)
    {
        if (array_key_exists($userRelationshipId, $this->friends) || array_key_exists($userRelationshipId, $this->following)) {
            return true;
        }

        return false;
    }
}
