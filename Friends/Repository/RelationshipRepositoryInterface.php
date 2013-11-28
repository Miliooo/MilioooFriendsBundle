<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Repository;

use Miliooo\Friends\Model\RelationshipInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * Class RelationshipRepositoryInterface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface RelationshipRepositoryInterface
{
    /**
     * Finds a relationship between the follower and the followed
     *
     * @param UserRelationship $userRelationship
     *
     * @return RelationshipInterface|null The relationship or null when not found
     */
    public function findRelationship(UserRelationship $userRelationship);

    /**
     * Saves a relationship
     *
     * @param RelationshipInterface $relationship The relationship we save
     * @param boolean               $flush        Whether to flush or not defaults to true
     */
    public function saveRelationship(RelationshipInterface $relationship, $flush = true);

    /**
     * Deletes a relationship
     *
     * @param RelationshipInterface $relationship The relationship we want to delete
     * @param boolean               $flush        Whether to flush or not defaults to true
     */
    public function deleteRelationship(RelationshipInterface $relationship, $flush = true);
}
