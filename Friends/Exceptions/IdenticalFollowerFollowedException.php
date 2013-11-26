<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Exceptions;

/**
 * This exception happens when we try to create a relationship where the follower and the followed are identical.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class IdenticalFollowerFollowedException extends FriendException
{

}
