<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Twig\Extension;

use Miliooo\Friends\User\LoggedInUserProviderInterface;
use Miliooo\Friends\Provider\UserRelationshipsProviderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Twig extension class
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class FriendsExtension extends \Twig_Extension
{
    /**
     * A logged in user provider instance.
     *
     * @var LoggedInUserProviderInterface
     */
    protected $loggedInUserProvider;

    /**
     * An user relation ship provider instance.
     *
     * @var UserRelationshipsProviderInterface
     */
    protected $userRelationshipProvider;

    /**
     * Constructor.
     *
     * @param LoggedInUserProviderInterface $loggedInUserProvider A logged in user provider instance
     * @param UserRelationshipsProviderInterface $userRelationshipProvider An user relationship provider instance
     */
    public function __construct(
        LoggedInUserProviderInterface $loggedInUserProvider,
        UserRelationshipsProviderInterface $userRelationshipProvider
    ) {
        $this->loggedInUserProvider = $loggedInUserProvider;
        $this->userRelationshipProvider = $userRelationshipProvider;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return [
            'miliooo_friends_is_following' => new \Twig_Function_Method($this, 'isFollowing')
        ];
    }

    /**
     * Checks if the logged in user (owner) is following the given user.
     *
     * @param string $userRelationshipId
     *
     * @return boolean true if the logged in user is following the owner, false otherwise
     */
    public function isFollowing($userRelationshipId)
    {
        $owner = $this->hasLoggedInUser();
        if (!$owner) {
            return false;
        }

        $userRelationships = $this->userRelationshipProvider->getUserRelationships($owner);
        if ($userRelationships->isFollowing($userRelationshipId)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'miliooo_friends';
    }

    /**
     * Checks if there is a logged in user.
     *
     * @return false|\Miliooo\Friends\User\UserRelationshipInterface
     */
    protected function hasLoggedInUser()
    {
        try {
            $user = $this->loggedInUserProvider->getAuthenticatedUser();
        } catch (AccessDeniedException $e) {
            return false;
        }

        return $user;
    }
}
