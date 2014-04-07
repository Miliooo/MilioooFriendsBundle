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
use Symfony\Component\HttpFoundation\JsonResponse;
use Miliooo\Friends\Exceptions\FriendException;
use Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException;
use Miliooo\Friends\Command\Handler\DeleteRelationshipCommandHandlerInterface;
use Miliooo\Friends\Command\DeleteRelationshipCommand;

/**
 * The delete friends controller is responsible for deleting relationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteFriendsController
{
    /**
     * @var LoggedInUserProviderInterface
     */
    private $loggedInUserProvider;

    /**
     * @var UserRelationshipTransformerInterface
     */
    private $transformer;

    /**
     * @var DeleteRelationshipCommandHandlerInterface
     */
    private $handler;

    /**
     * Constructor.
     *
     * @param LoggedInUserProviderInterface             $loggedInUserProvider
     * @param UserRelationshipTransformerInterface      $transformer
     * @param DeleteRelationshipCommandHandlerInterface $handler
     */
    public function __construct(
        LoggedInUserProviderInterface $loggedInUserProvider,
        UserRelationshipTransformerInterface $transformer,
        DeleteRelationshipCommandHandlerInterface $handler
    )
    {
        $this->loggedInUserProvider = $loggedInUserProvider;
        $this->transformer = $transformer;
        $this->handler = $handler;
    }

    /**
     * @param mixed $userRelationshipId
     *
     * @return JsonResponse
     */
    public function deleteRelationship($userRelationshipId)
    {
        $loggedInUser = $this->loggedInUserProvider->getAuthenticatedUser();
        $followed = $this->transformer->transformToObject($userRelationshipId);

        $data['user_relationship_id'] = $userRelationshipId;
        $data['error'] = false;

        try {
            $userRelationship = new UserRelationship($loggedInUser, $followed);
        } catch (FriendException $e) {
            if ($e instanceof IdenticalFollowerFollowedException) {
                //impossible user relationship
                $data['error'] = true;
            } else {
                //uncaught error
                $data['error'] = true;
            }
        }
        //we can't create the user relationship value object. This should never happen
        if ($data['error'] === true) {

            return new JsonResponse($data);
        }

        $command = new DeleteRelationshipCommand();
        $command->setUserRelationship($userRelationship);
        $command->setLoggedInUser($loggedInUser);
        //since we want our handlers to be able to be asynchronous we don't check if they really handled it.
        //worst thing that could happen is an user deleted a friendship but it didn't got deleted.
        $this->handler->handle($command);

        $data['success'] = true;

        return new JsonResponse($data);
    }
}
