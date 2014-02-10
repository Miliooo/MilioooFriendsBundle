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
    public function getFollowing(UserRelationshipInterface $user)
    {
        $relationships = $this->repository->getFollowing($user);

        $following = [];
        foreach ($relationships as $relationship) {
            $following[] = $relationship->getFollowed();
        }

        return $following;
    }

    /**
     * {@inheritdoc}
     */
    public function getFollowers(UserRelationshipInterface $user)
    {
        $followers = [];
        $relationships = $this->repository->getFollowers($user);
        foreach ($relationships as $relationship) {
            $followers[] = $relationship->getFollower();
        }

        return $followers;
    }

    /**
     * {@inheritDoc}
     */
    public function getFriends(UserRelationshipInterface $user)
    {
        $following = $this->getFollowing($user);
        $followers = $this->getFollowers($user);

        return $this->getFriendsFromFollowingAndFollowers($following, $followers);

    }

    /**
     * Gets the friends from intersecting the following and followers
     *
     * @param UserRelationshipInterface[] $following
     * @param UserRelationshipInterface[] $followers
     *
     * @return UserRelationshipInterface[]
     */
    protected function getFriendsFromFollowingAndFollowers($following, $followers)
    {
        $friends = array_intersect($following, $followers);

        return array_values($friends);
    }

    /**
     *
     */
    public function getAllRelationships(UserRelationshipInterface $user)
    {
        $data['followers'] = $this->getFollowers($user);
        $data['following'] = $this->getFollowing($user);
        $data['friends'] = $this->getFriendsFromFollowingAndFollowers($data['following'], $data['followers']);

        return $data;
    }
}
