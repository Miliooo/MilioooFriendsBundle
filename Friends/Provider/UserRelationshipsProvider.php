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
use Miliooo\Friends\User\UserRelationshipInterface;
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
     * Gets an array with people following the given user.
     *
     * @param UserRelationshipInterface $user
     *
     * @return array
     */
    protected function getFollowingArray(UserRelationshipInterface $user)
    {
        $relationships = $this->repository->getFollowing($user);

        $following = [];
        foreach ($relationships as $relationship) {
            $following[] = $relationship->getFollowed();
        }

        return $following;
    }

    /**
     * Gets an array with followers from the given user.
     *
     * @param UserRelationshipInterface $user
     *
     * @return array
     */
    protected function getFollowersArray(UserRelationshipInterface $user)
    {
        $followers = [];
        $relationships = $this->repository->getFollowers($user);
        foreach ($relationships as $relationship) {
            $followers[] = $relationship->getFollower();
        }

        return $followers;
    }

    /**
     * Gets the friends from intersecting the following and followers
     *
     * @param UserRelationshipInterface[] $following
     * @param UserRelationshipInterface[] $followers
     *
     * @return UserRelationshipInterface[]
     */
    protected function getFriendsFromFollowingAndFollowersArray($following, $followers)
    {
        $friends = array_intersect($following, $followers);

        return array_values($friends);
    }

    /**
     * Gets an array with all the relationships from the given user.
     *
     * @param UserRelationshipInterface $user
     *
     * @return array
     */
    protected function getAllRelationships(UserRelationshipInterface $user)
    {
        $data['followers'] = $this->getFollowersArray($user);
        $data['following'] = $this->getFollowingArray($user);
        $data['friends'] = $this->getFriendsFromFollowingAndFollowersArray($data['following'], $data['followers']);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserRelationships(UserRelationshipInterface $user)
    {
        $data = $this->getAllRelationships($user);

        return new UserRelationships($user, $data['friends'], $data['followers'], $data['following']);
    }
}
