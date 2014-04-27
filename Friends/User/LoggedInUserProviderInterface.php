<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\User;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * This interface is responsible for providing the logged in user.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface LoggedInUserProviderInterface
{
    /**
     * Gets the authenticated User.
     *
     * This method is responsible for returning the authenticated user.
     *
     * If there is no authenticated user or the user does not implement
     * the UserIdentifierInterface an AccessDeniedException should be thrown.
     *
     * @return UserIdentifierInterface
     *
     * @throws AccessDeniedException if no authenticated or valid logged in user
     */
    public function getAuthenticatedUser();
}
