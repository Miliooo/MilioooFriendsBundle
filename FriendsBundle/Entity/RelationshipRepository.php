<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Miliooo\Friends\Model\RelationshipInterface;
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;
use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Doctrine orm Implementation of the relationship repository interface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipRepository extends EntityRepository implements RelationshipRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findRelationship(UserRelationship $userRelationship)
    {
        return $this->findOneBy(
            [
                'follower' => $userRelationship->getFollower(),
                'followed' => $userRelationship->getFollowed()
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function saveRelationship(RelationshipInterface $relationship, $flush = true)
    {
        $em = $this->getEntityManager();
        $em->persist($relationship);

        if ($flush) {
            $em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRelationship(RelationshipInterface $relationship, $flush = true)
    {
        $em = $this->getEntityManager();
        $em->remove($relationship);

        if ($flush) {
            $em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFollowing(UserIdentifierInterface $user)
    {
        return $this->findBy(['follower' => $user]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFollowers(UserIdentifierInterface $user)
    {
        return $this->findBy(['followed' => $user]);
    }
}
