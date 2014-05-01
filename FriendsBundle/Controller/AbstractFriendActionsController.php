<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Controller;

use Miliooo\Friends\User\LoggedInUserProviderInterface;
use Miliooo\Friends\User\UserRelationshipTransformerInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;
use Miliooo\Friends\Exceptions\FriendException;
use Miliooo\Friends\User\UserIdentifierInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractFriendActionsController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
abstract class AbstractFriendActionsController
{
    /**
     * A logged in user provider instance.
     *
     * @var LoggedInUserProviderInterface
     */
    protected $loggedInUserProvider;

    /**
     * An userRelationshipTransformer instance.
     *
     * @var UserRelationshipTransformerInterface
     */
    protected $transformer;

    protected $data = [];

    /**
     * Constructor.
     *
     * @param LoggedInUserProviderInterface             $loggedInUserProvider
     * @param UserRelationshipTransformerInterface      $transformer
     */
    public function __construct(
        LoggedInUserProviderInterface $loggedInUserProvider,
        UserRelationshipTransformerInterface $transformer
    ) {
        $this->loggedInUserProvider = $loggedInUserProvider;
        $this->transformer = $transformer;
    }

    /**
     * Gets the logged in user.
     *
     * @return UserIdentifierInterface
     */
    protected function getLoggedInUser()
    {
        return $this->loggedInUserProvider->getAuthenticatedUser();
    }

    /**
     * Transforms the userRelationshipId to an UserIdentifier object.
     *
     * @param mixed $userRelationshipId
     *
     * @return UserIdentifierInterface
     */
    protected function getUserIdentifierObject($userRelationshipId)
    {
        $followed = $this->transformer->transformToObject($userRelationshipId);

        return $followed;
    }

    /**
     * Creates a new userRelationship or handles the error.
     *
     * @param UserIdentifierInterface $loggedInUser
     * @param UserIdentifierInterface $followed
     *
     * @return UserRelationship|JsonResponse
     */
    protected function getUserRelationshipOrHandleError(UserIdentifierInterface $loggedInUser, UserIdentifierInterface $followed)
    {
        try {
            $userRelationship = new UserRelationship($loggedInUser, $followed);

        } catch (FriendException $e) {
            return $this->handleError('An error has occurred');
        }

        if ($userRelationship instanceof UserRelationship) {
            return $userRelationship;
        }

        return $this->handleError('An error has occurred');
    }

    /**
     * Handles the error.
     *
     * Adds an error to the data.
     * Adds an error reason to the data
     * Returns a new json response
     *
     * @param string $errorMsg
     *
     * @return JsonResponse
     */
    protected function handleError($errorMsg)
    {
        $this->setData('error', true);
        $this->setData('error_msg', $errorMsg);

        return new JsonResponse($this->getData());
    }

    /**
     * Sets the data.
     *
     * This is an array with the data we will return as json response.
     *
     * @param string $key
     * @param mixed  $value
     */
    protected function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Returns the data.
     *
     * This is public since we want to use this to unit test against the expected response.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
