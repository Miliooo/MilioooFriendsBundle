<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Command\Handler;

use Miliooo\Friends\Command\DeleteRelationshipCommand;
use Miliooo\Friends\Deleter\RelationshipDeleterSecureInterface;
use Miliooo\Friends\Event\MilioooFriendsEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Miliooo\Friends\Event\RelationshipEvent;
use Miliooo\Friends\Repository\RelationshipRepositoryInterface;

/**
 * Handler responsible for handling the delete relationship command.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DeleteRelationshipCommandHandler implements DeleteRelationshipCommandHandlerInterface
{
    /**
     * @var RelationshipDeleterSecureInterface
     */
    private $relationshipDeleter;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var RelationshipRepositoryInterface
     */
    private $repository;

    /**
     * Constructor.
     *
     * @param RelationshipDeleterSecureInterface $relationshipDeleter
     * @param RelationshipRepositoryInterface    $repository
     * @param EventDispatcherInterface           $dispatcher
     */
    public function __construct(
        RelationshipDeleterSecureInterface $relationshipDeleter,
        RelationshipRepositoryInterface $repository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->relationshipDeleter = $relationshipDeleter;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Handles the deleting of an relationship
     *
     * @param DeleteRelationshipCommand $command
     */
    public function handle(DeleteRelationshipCommand $command)
    {
        //the deleter wants a relationship object as instance... we could update the deleter or get the object here...
        $relationship = $this->repository->findRelationship($command->getUserRelationship());

        //no relationship found return
        if (!$relationship) {
            return;
        }

        try {
            $this->relationshipDeleter->deleteRelationship(
                $command->getLoggedInUser(),
                $relationship
            );
        } catch (\Exception $e) {
            return;
        }

        $event = new RelationshipEvent($relationship);

        $this->dispatcher->dispatch(MilioooFriendsEvents::RELATIONSHIP_REMOVED, $event);
    }
}
