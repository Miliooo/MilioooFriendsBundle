<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Provider;

use Miliooo\Friends\User\UserRelationshipInterface;
use Miliooo\Friends\Model\UserRelationships;

/**
 * Provides the relationships for a single user
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface UserRelationshipsProviderInterface
{
    /**
     * Gets the user relationships.
     *
     * @param UserRelationshipInterface $user The user for whom we get the relationships.
     *
     * @return UserRelationships An user relationships object.
     */
    public function getUserRelationships(UserRelationshipInterface $user);
}
