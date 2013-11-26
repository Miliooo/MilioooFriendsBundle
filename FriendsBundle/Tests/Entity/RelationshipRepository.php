<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Tests\Entity;

use Doctrine\ORM\EntityRepository;
use Miliooo\Friends\Model\Relationship;
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;
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
        // TODO: Implement findRelationship() method.
    }

    /**
     * {@inheritdoc}
     */
    public function saveRelationship(Relationship $relationship, $flush = true)
    {
        $em = $this->getEntityManager();
        $em->persist($relationship);

        if($flush)
        {
            $em->flush();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRelationship(Relationship $relationship)
    {
        $em = $this->getEntityManager();
        $em->remove($relationship);
    }
}
