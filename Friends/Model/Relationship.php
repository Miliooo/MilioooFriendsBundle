<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Model;

use Miliooo\Friends\User\UserRelationshipInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;

/**
 * The Relationship model
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class Relationship implements RelationshipInterface
{
    /**
     * The user who decides to follow another user.
     *
     * @var UserRelationshipInterface
     */
    protected $follower;

    /**
     * The user who is being followed.
     *
     * @var UserRelationshipInterface
     */
    protected $followed;

    /**
     * The datetime when the relationship has been created.
     *
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * Constructor.
     *
     * @param UserRelationship $userRelationship An user relationship instance
     * @param \DateTime        $dateCreated      The date the relationship was created
     */
    public function __construct(UserRelationship $userRelationship, \DateTime $dateCreated)
    {
        $this->follower = $userRelationship->getFollower();
        $this->followed = $userRelationship->getFollowed();
        $this->dateCreated = $dateCreated;
    }

    /**
     * {@inheritdoc}
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * {@inheritdoc}
     */
    public function getFollowed()
    {
        return $this->followed;
    }

    /**
     * {@inheritdoc}
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
}
