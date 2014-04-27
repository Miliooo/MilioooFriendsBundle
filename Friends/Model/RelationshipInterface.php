<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Model;

use Miliooo\Friends\User\UserIdentifierInterface;

/**
 * The Relationship model interface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface RelationshipInterface
{
    /**
     * Gets the follower person.
     *
     * If Mike wants to follow Ann then Mike is the follower and Ann is being followed.
     * The getFollower will return Mike
     *
     * @return UserIdentifierInterface The person who follows another person.
     */
    public function getFollower();

    /**
     * Gets the followed person.
     *
     * If Mike wants to follow Ann then Mike is the follower and Ann is being followed.
     * The getFollowed will return Ann
     *
     * @return UserIdentifierInterface The person who is being followed.
     */
    public function getFollowed();

    /**
     * Returns the date time instance from when the relationship was created.
     *
     * @return \DateTime The dateTIme when the relationship was created.
     */
    public function getDateCreated();
}
