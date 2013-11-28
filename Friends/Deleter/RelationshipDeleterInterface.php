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

/**
 * Deletes relationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface RelationshipDeleterInterface
{
    /**
     * @param RelationshipInterface $relationship The relationship object we want to delete
     *
     * @return RelationshipInterface The relationship that we deleted.
     */
    public function deleteRelationship(RelationshipInterface $relationship);
}
