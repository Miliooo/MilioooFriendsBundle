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
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;

/**
 * Deletes relationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipDeleter implements RelationshipDeleterInterface
{
    /**
     * A relation ship repository instance.
     *
     * @var RelationshipRepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param RelationshipRepositoryInterface $repository
     */
    public function __construct(RelationshipRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteRelationship(RelationshipInterface $relationship)
    {
        $this->repository->deleteRelationship($relationship);

        return $relationship;
    }
}
