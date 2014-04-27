<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Provider;

use Miliooo\Friends\Model\UserRelationships;
use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;


/**
 * Provides the relationships for a single user
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipsProvider implements UserRelationshipsProviderInterface
{
    /**
     * @var RelationshipRepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param RelationshipRepositoryInterface $relationshipRepository
     */
    public function __construct(RelationshipRepositoryInterface $relationshipRepository)
    {
        $this->repository = $relationshipRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserRelationships(UserIdentifierInterface $user)
    {
        $data = $this->getAllRelationships($user);

        return new UserRelationships($user->getIdentifierId(), $data['friends'], $data['followers'], $data['following']);
    }

    /**
     * Gets an array with people following the given user.
     *
     * @param UserIdentifierInterface $user
     *
     * @return array
     */
    private function getFollowingArray(UserIdentifierInterface $user)
    {
        $relationships = $this->repository->getFollowing($user);

        $following = [];
        foreach ($relationships as $relationship) {
            $following[$relationship->getFollowed()->getIdentifierId()] = 1;
        }

        return $following;
    }

    /**
     * Gets an array with followers from the given user.
     *
     * @param UserIdentifierInterface $user
     *
     * @return array
     */
    private function getFollowersArray(UserIdentifierInterface $user)
    {
        $followers = [];
        $relationships = $this->repository->getFollowers($user);
        foreach ($relationships as $relationship) {
            $followers[$relationship->getFollower()->getIdentifierId()] = 1;
        }

        return $followers;
    }

    /**
     * Gets the friends from intersecting the following and followers
     *
     * @param UserIdentifierInterface[] $following
     * @param UserIdentifierInterface[] $followers
     *
     * @return UserIdentifierInterface[]
     */
    private function getFriendsFromFollowingAndFollowersArray($following, $followers)
    {
        return array_intersect_key($following, $followers);

    }

    /**
     * Gets an array with all the relationships from the given user.
     *
     * @param UserIdentifierInterface $user
     *
     * @return array
     */
    private function getAllRelationships(UserIdentifierInterface $user)
    {
        $data['followers'] = $this->getFollowersArray($user);
        $data['following'] = $this->getFollowingArray($user);
        $data['friends'] = $this->getFriendsFromFollowingAndFollowersArray($data['following'], $data['followers']);

        return $data;
    }
}
