<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Deleter;

use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\Model\RelationshipInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Interface for safely delete relationships.
 *
 * We only delete the relationship if the given user has enough rights to delete that relationship.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface RelationshipDeleterSecureInterface
{
    /**
     * Deletes a relationship if the given user has enough rights to do so.
     *
     * @param UserIdentifierInterface $user         The user we want to check the permissions to delete
     * @param RelationshipInterface     $relationship The relationship we want to check if the user can delete this
     *
     * @return RelationshipInterface The relationship we deleted.
     *
     * @throws AccessDeniedException if the user has not enough rights to delete this thread.
     */
    public function deleteRelationship(UserIdentifierInterface $user, RelationshipInterface $relationship);
}
