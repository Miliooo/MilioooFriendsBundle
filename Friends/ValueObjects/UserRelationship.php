<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\ValueObjects;

use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException;

/**
 * User relationship value object.
 *
 * Since there is a connection between a follower and a someone who is followed we created this value object for it.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationship
{
    /**
     * @var UserIdentifierInterface
     */
    private $follower;

    /**
     * @var UserIdentifierInterface
     */
    private $followed;

    /**
     * Constructor.
     *
     * @param UserIdentifierInterface $follower
     * @param UserIdentifierInterface $followed
     *
     * @throws IdenticalFollowerFollowedException
     */
    public function __construct(UserIdentifierInterface $follower, UserIdentifierInterface $followed)
    {
        if ($follower->getIdentifierId() === $followed->getIdentifierId()) {
            throw new IdenticalFollowerFollowedException();
        }

        $this->follower = $follower;
        $this->followed = $followed;
    }

    /**
     * Gets the follower.
     *
     * @return UserIdentifierInterface
     */
    public function getFollower()
    {
        return $this->follower;
    }

    /**
     * Gets the person who is being followed.
     *
     * @return UserIdentifierInterface
     */
    public function getFollowed()
    {
        return $this->followed;
    }
}
