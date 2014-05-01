<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Command;

/**
 * Class CreateRelationshipCommand
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateRelationshipCommand extends AbstractRelationshipCommand
{
    /**
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * Sets the date created.
     *
     * @param \DateTime $dateCreated
     */
    public function setDateCreated(\DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * Gets the date the relationship was created.
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
