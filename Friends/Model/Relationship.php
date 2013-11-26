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
     * @param UserRelationshipInterface $follower    The user who decides to follow another user (= follower)
     * @param UserRelationshipInterface $followed    The user who is being followed (=followed)
     * @param \DateTime                 $dateCreated The date the relationship was created
     */
    public function __construct(UserRelationshipInterface $follower, UserRelationshipInterface $followed, \DateTime $dateCreated)
    {
        $this->follower = $follower;
        $this->followed = $followed;
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
