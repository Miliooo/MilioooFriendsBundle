<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\User;

/**
 * Interface UserRelationshipTransformerInterface
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface UserRelationshipTransformerInterface
{
    /**
     * Transforms the user relationship id to an UserIdentifierInterface object.
     *
     * @param mixed $userRelationshipId
     *
     * @return UserIdentifierInterface;
     */
    public function transformToObject($userRelationshipId);
}
