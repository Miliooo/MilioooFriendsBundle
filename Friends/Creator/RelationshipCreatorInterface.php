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
use Miliooo\Friends\Model\RelationshipInterface;
use Miliooo\Friends\Exceptions\RelationshipAlreadyExistsException;

/**
 * The relationshipCreator is responsible for creating new relationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface RelationshipCreatorInterface
{
    /**
     * Creates a relationship
     *
     * @param UserRelationship $userRelationship The user relationship object
     * @param \DateTime        $dateCreated      The datetime when the relationship was created
     *
     * @return RelationshipInterface The saved object
     *
     * @throws RelationshipAlreadyExistsException When trying to create a relationship that already exists.
     */
    public function createRelationship(UserRelationship $userRelationship, \DateTime $dateCreated);
}
