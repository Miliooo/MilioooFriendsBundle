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
        // TODO: Implement getFriends() method.
    }
}
