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
 * Since all the checks for a given relationship between two users only depends on the identifierId there is no need
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
     * @param []     $friendIds    Array with friend identifierIds where the keys are the identifierIds
     * @param []     $followerIds  Array with follower identifierIds where the keys are the identifierIds
     * @param []     $followingIds Array with following identifierIds where the keys are the identifierIds
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
    public function isFollowing($identifierId)
    {
        if ($this->isOwnerFriendsWithOrFollowingUser($identifierId)) {
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
     * {@inheritdoc}
     */
    public function getAllIdentifierIds()
    {
        $allIds = array_merge(array_keys($this->followers), array_keys($this->following));

        return array_unique($allIds);
    }

    /**
     * Checks if the owner is friendIds with or follows the given user.
     *
     * @param string $identifierId The user for whom we check if the owner is following or friend with him
     *
     * @return boolean True if there is a relationship, false otherwise
     */
    protected function isOwnerFriendsWithOrFollowingUser($identifierId)
    {
        if (array_key_exists($identifierId, $this->friends) || array_key_exists($identifierId, $this->following)) {
            return true;
        }

        return false;
    }
}
