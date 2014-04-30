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
use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\User\UserRelationshipTransformerInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;
use Symfony\Component\HttpFoundation\JsonResponse;
use Miliooo\Friends\Command\Handler\DeleteRelationshipCommandHandlerInterface;
use Miliooo\Friends\Command\DeleteRelationshipCommand;

/**
 * The delete friends controller is responsible for deleting relationships
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteFriendsController extends AbstractFriendActionsController
{
    /**
     * @var DeleteRelationshipCommandHandlerInterface
     */
    private $handler;

    /**
     * Constructor.
     *
     * @param LoggedInUserProviderInterface             $userProvider
     * @param UserRelationshipTransformerInterface      $transformer
     * @param DeleteRelationshipCommandHandlerInterface $handler
     */
    public function __construct(
        LoggedInUserProviderInterface $userProvider,
        UserRelationshipTransformerInterface $transformer,
        DeleteRelationshipCommandHandlerInterface $handler
    ) {
        $this->handler = $handler;
        parent::__construct($userProvider, $transformer);
    }

    /**
     * @param mixed $userRelationshipId
     *
     * @return JsonResponse
     */
    public function deleteRelationship($userRelationshipId)
    {
        $loggedInUser = $this->getLoggedInUser();
        $followed = $this->getUserIdentifierObject($userRelationshipId);

        $this->setData('action', 'unfollow');
        $this->setData('user_relationship_id', $userRelationshipId);

        $userRelationshipOrError = $this->getUserRelationshipOrHandleError($loggedInUser, $followed);

        if ($userRelationshipOrError instanceof JsonResponse) {
            return $userRelationshipOrError;
        }

        //let's rename it so it makes sense again
        $userRelationship = $userRelationshipOrError;

        $command = $this->getCommandForHandler($userRelationship, $loggedInUser);

        //since we want our handlers to be able to be asynchronous we don't check if they really handled it.
        //worst thing that could happen is an user deleted a friendship but it didn't got deleted.
        $this->handler->handle($command);

        return new JsonResponse($this->getData());
    }

    /**
     * Creates the command we will use in our handle.
     *
     * @param UserRelationship        $userRelationship
     * @param UserIdentifierInterface $loggedInUser
     *
     * @return DeleteRelationshipCommand
     */
    protected function getCommandForHandler(UserRelationship $userRelationship, UserIdentifierInterface $loggedInUser)
    {
        $command = new DeleteRelationshipCommand();
        $command->setUserRelationship($userRelationship);
        $command->setLoggedInUser($loggedInUser);

        return $command;
    }
}
