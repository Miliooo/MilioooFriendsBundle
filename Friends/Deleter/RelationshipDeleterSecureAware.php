<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Deleter;

use Miliooo\Friends\Model\RelationshipInterface;
use Miliooo\Friends\User\UserRelationshipInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Miliooo\Friends\Specifications\CanDeleteRelationshipSpecificationInterface;

/**
 * A secure aware relationship deleter which uses the can delete relationship specification
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipDeleterSecureAware implements RelationshipDeleterSecureInterface
{
    /**
     * A relationship deleter instance.
     *
     * @var RelationshipDeleterInterface
     */
    private $relationshipDeleter;

    /**
     * A can delete relationship specification instance.
     *
     * @var CanDeleteRelationshipSpecificationInterface
     */
    private $canDeleteSpecification;

    /**
     * Constructor.
     *
     * @param RelationshipDeleterInterface                $relationshipDeleter   A relationship deleter instance
     * @param CanDeleteRelationshipSpecificationInterface $canDeleteRelationship A can delete specification instance
     */
    public function __construct(
        RelationshipDeleterInterface $relationshipDeleter,
        CanDeleteRelationshipSpecificationInterface $canDeleteRelationship
    ) {
        $this->relationshipDeleter = $relationshipDeleter;
        $this->canDeleteSpecification = $canDeleteRelationship;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteRelationship(UserRelationshipInterface $user, RelationshipInterface $relationship)
    {
        if ($this->canDeleteSpecification->isSatisfiedBy($user, $relationship) === false) {
            throw new AccessDeniedException('Not enough rights to delete this relationship');
        }

        $this->relationshipDeleter->deleteRelationship($relationship);

        return $relationship;
    }
}
