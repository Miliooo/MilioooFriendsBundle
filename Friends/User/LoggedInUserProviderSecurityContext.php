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
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Class LoggedInUserProviderSecurityContext
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class LoggedInUserProviderSecurityContext implements LoggedInUserProviderInterface
{
    /**
     * A security context instance.
     *
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * Constructor.
     *
     * @param SecurityContextInterface $securityContext A security context interface
     */
    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthenticatedUser()
    {
        $loggedInUser = $this->securityContext->getToken()->getUser();

        if (!is_object($loggedInUser) || !$loggedInUser instanceof UserIdentifierInterface) {
            throw new AccessDeniedException('You must be logged in with a UserIdentifierInterface');
        }

        return $loggedInUser;
    }
}
