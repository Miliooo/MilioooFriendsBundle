<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Specifications;

use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\Model\RelationshipInterface;

/**
 * This specification is responsible for deciding whether the given user is allowed to delete the given relationship.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CanDeleteRelationshipSpecification implements CanDeleteRelationshipSpecificationInterface
{
    /**
     * Decides whether the given user can delete the given relationship.
     *
     * @param UserIdentifierInterface $user
     * @param RelationshipInterface     $relationship
     *
     * @return boolean true if the given user can delete the given relationship, false otherwise
     */
    public function isSatisfiedBy(UserIdentifierInterface $user, RelationshipInterface $relationship)
    {
        return $this->isCreatorOfRelationship($user, $relationship);
    }

    /**
     * Checks if the given user is the creator of the relationship.
     *
     * @param UserIdentifierInterface $user
     * @param RelationshipInterface     $relationship
     *
     * @return boolean true if user is creator of relationship, false otherwise.
     */
    protected function isCreatorOfRelationship(UserIdentifierInterface $user, RelationshipInterface $relationship)
    {
        $followerRelationshipId = $relationship->getFollower()->getIdentifierId();
        $userRelationshipId = $user->getIdentifierId();

        if ($followerRelationshipId !== $userRelationshipId) {
            return false;
        }

        return true;
    }
}
