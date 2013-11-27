<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Creator;

use Miliooo\Friends\ValueObjects\UserRelationship;
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;
use Miliooo\Friends\Model\RelationshipInterface;
use Miliooo\Friends\Exceptions\RelationshipAlreadyExistsException;

/**
 * Class RelationshipCreator
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipCreator implements RelationshipCreatorInterface
{
    /**
     * A relationshipRepository instance
     *
     * @var \Miliooo\Friends\Repository\RelationshipRepositoryInterface
     */
    protected $relationshipRepository;

    /**
     * FQCN of the relationship class
     *
     * @var string
     */
    protected $relationshipClass;

    /**
     * @param RelationshipRepositoryInterface $relationshipRepository A relationship repository instance
     * @param string                          $relationshipClass      FQCN of the relationship class
     */
    public function __construct(RelationshipRepositoryInterface $relationshipRepository, $relationshipClass)
    {
        $this->relationshipRepository = $relationshipRepository;
        $this->relationshipClass = $relationshipClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createRelationship(UserRelationship $userRelationship, \DateTime $dateCreated)
    {
        $this->guardAgainstExistingRelationship($userRelationship);

        $relationship = $this->createRelationshipObject($userRelationship, $dateCreated);
        $this->relationshipRepository->saveRelationship($relationship);

        return $relationship;
    }

    /**
     * Creates a relationship object from the fully qualified class name
     *
     * @param UserRelationship $userRelationship A user relationship object
     * @param \DateTime        $dateCreated      The date the relationship was created
     *
     * @return RelationshipInterface
     */
    protected function createRelationshipObject(UserRelationship $userRelationship, \DateTime $dateCreated)
    {
        return new $this->relationshipClass($userRelationship, $dateCreated);
    }

    /**
     * Guards against relationships that already exists.
     *
     * @param UserRelationship $userRelationship
     *
     * @throws RelationshipAlreadyExistsException
     */
    protected function guardAgainstExistingRelationship(UserRelationship $userRelationship)
    {
        if ($this->relationshipRepository->findRelationship($userRelationship) !== null) {
            throw new RelationshipAlreadyExistsException();
        }
    }
}
