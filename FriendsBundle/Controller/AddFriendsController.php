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
use Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandlerInterface;
use Miliooo\Friends\Command\CreateRelationshipCommand;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This controller is responsible for adding friends.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AddFriendsController extends AbstractFriendActionsController
{
    /**
     * @var CreateRelationshipCommandHandlerInterface
     */
    protected $handler;

    /**
     * Constructor.
     *
     * @param CreateRelationshipCommandHandlerInterface $handler
     * @param LoggedInUserProviderInterface             $userProvider
     * @param UserRelationshipTransformerInterface      $transformer
     */
    public function __construct(
        CreateRelationshipCommandHandlerInterface $handler,
        LoggedInUserProviderInterface $userProvider,
        UserRelationshipTransformerInterface $transformer
    ) {
        $this->handler = $handler;
        parent::__construct($userProvider, $transformer);
    }

    /**
     * @param mixed $userRelationshipId
     *
     * @return JsonResponse
     */
    public function addFriendsAction($userRelationshipId)
    {
        $loggedInUser = $this->getLoggedInUser();
        $followed = $this->getUserIdentifierObject($userRelationshipId);

        $this->setData('action', 'follow');
        $this->setData('user_relationship_id', $userRelationshipId);

        $userRelationshipOrError = $this->getUserRelationshipOrHandleError($loggedInUser, $followed);

        if ($userRelationshipOrError instanceof JsonResponse) {
            return $userRelationshipOrError;
        }

        //let's rename it so it makes sense again
        $userRelationship = $userRelationshipOrError;
        $command = $this->getCommandForHandler($userRelationship);

        $this->doHandleCommand($command);

        return new JsonResponse($this->getData());
    }

    /**
     * @param UserRelationship $userRelationship
     *
     * @return CreateRelationshipCommand
     */
    protected function getCommandForHandler(UserRelationship $userRelationship)
    {
        $command = new CreateRelationshipCommand();
        $command->setDateCreated(new \DateTime('now'));
        $command->setUserRelationship($userRelationship);

        return $command;
    }

    /**
     * @param CreateRelationshipCommand $command
     */
    protected function doHandleCommand(CreateRelationshipCommand $command)
    {
        try {
            $this->handler->handle($command);

        } catch (\Exception $e) {

        }
    }
}
