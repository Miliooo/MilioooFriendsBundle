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
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;
use Miliooo\Friends\Deleter\RelationshipDeleterSecureInterface;
use Symfony\Component\HttpFoundation\Response;
use Miliooo\Friends\Exceptions\FriendException;
use Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException;
use Miliooo\Friends\User\UserRelationshipInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * The delete friends controller is responsible for deleting relationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteFriendsController
{
    /**
     * @var \Miliooo\Friends\User\LoggedInUserProviderInterface
     */
    private $loggedInUserProvider;

    /**
     * @var \Miliooo\Friends\User\UserRelationshipTransformerInterface
     */
    private $transformer;

    /**
     * @var \Miliooo\Friends\Repository\RelationshipRepositoryInterface
     */
    private $repository;

    private $deleter;

    /**
     * Constructor.
     *
     * @param LoggedInUserProviderInterface $loggedInUserProvider
     * @param UserRelationshipTransformerInterface $transformer
     * @param RelationshipRepositoryInterface $repository
     * @param RelationshipDeleterSecureInterface $deleter
     */
    public function __construct(
        LoggedInUserProviderInterface $loggedInUserProvider,
        UserRelationshipTransformerInterface $transformer,
        RelationshipRepositoryInterface $repository,
        RelationshipDeleterSecureInterface $deleter
    )
    {
        $this->loggedInUserProvider = $loggedInUserProvider;
        $this->transformer = $transformer;
        $this->repository = $repository;
        $this->deleter = $deleter;
    }

    /**
     * Deletes a relationship for the logged in user.
     *
     * @param mixed $userRelationshipId
     *
     * @return response
     */
    public function deleteRelationship($userRelationshipId)
    {
        $loggedInUser = $this->loggedInUserProvider->getAuthenticatedUser();
        $followed = $this->transformer->transformToObject($userRelationshipId);

        //try to make an user relationship value object, catches the errors and returns a failure response when failed.
        $userRelationshipOrResponse = $this->getUserRelationshipOrErrorResponse($loggedInUser, $followed);
        if ($userRelationshipOrResponse instanceof Response) {
            return $userRelationshipOrResponse;
        }

        //rename this so it makes sense again....
        $userRelationship = $userRelationshipOrResponse;

        $relationship = $this->repository->findRelationship($userRelationship);
        if ($relationship === null) {
            return $this->onFailure('the relationship does not exist');
        }

        try {
            $this->deleter->deleteRelationship($loggedInUser, $relationship);
        } catch (AccessDeniedException $e) {
            return $this->onFailure('Not enough rights to delete this relationship');
        }

        return $this->onSuccess();
    }

    /**
     * @return Response
     */
    public function onSuccess()
    {
        return new Response('success');
    }

    /**
     * @param string $failureReason
     *
     * @return Response
     */
    public function onFailure($failureReason)
    {
        return new Response($failureReason);
    }

    /**
     * Tries to create a user relationship object catches the exceptions when failed and returns an onFailure response.
     *
     * @param UserRelationshipInterface $loggedInUser The logged in user
     * @param UserRelationshipInterface $followed     The followed user
     *
     * @return Response|UserRelationship
     */
    protected function getUserRelationshipOrErrorResponse(UserRelationshipInterface $loggedInUser, UserRelationshipInterface $followed)
    {
        try {
            $userRelationship = new UserRelationship($loggedInUser, $followed);
        } catch (FriendException $e) {
            if ($e instanceof IdenticalFollowerFollowedException) {
                return $this->onFailure('You can not add or delete yourself');
            } else {
                return $this->onFailure('unknown exception');
            }
        }

        return $userRelationship;
    }
}
