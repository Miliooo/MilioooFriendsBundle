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
 * Class UserRelationshipProviderSecurityContext
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class UserRelationshipProviderSecurityContext implements UserRelationshipProviderInterface
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

        if (!is_object($loggedInUser) || !$loggedInUser instanceof UserRelationshipInterface) {
            throw new AccessDeniedException('You must be logged in with a UserRelationshipInterface');
        }

        return $loggedInUser;
    }
}
