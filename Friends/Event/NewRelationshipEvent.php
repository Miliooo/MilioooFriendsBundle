<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Event;

use Symfony\Component\EventDispatcher\Event;
use Miliooo\Friends\Model\RelationshipInterface;

/**
 * Class NewRelationshipEvent
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class NewRelationshipEvent extends Event
{
    private $relationship;

    /**
     * Constructor.
     *
     * @param RelationshipInterface $relationship
     */
    public function __construct(RelationshipInterface $relationship)
    {
        $this->relationship = $relationship;
    }

    /**
     * Gets the newly created relationship
     *
     * @return RelationshipInterface
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

}
