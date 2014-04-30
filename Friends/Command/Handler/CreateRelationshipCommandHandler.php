<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Command\Handler;

use Miliooo\Friends\Creator\RelationshipCreatorInterface;
use Miliooo\Friends\Command\CreateRelationshipCommand;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Miliooo\Friends\Event\MilioooFriendsEvents;
use Miliooo\Friends\Event\RelationshipEvent;
use Miliooo\Friends\Exceptions\RelationshipAlreadyExistsException;

/**
 * The create relationship command handler is responsible for handling the create relationship command.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class CreateRelationshipCommandHandler implements CreateRelationshipCommandHandlerInterface
{
    /**
     * @var RelationshipCreatorInterface
     */
    private $relationshipCreator;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Constructor.
     *
     * @param RelationshipCreatorInterface $relationshipCreator
     * @param EventDispatcherInterface     $dispatcher
     */
    public function __construct(RelationshipCreatorInterface $relationshipCreator, EventDispatcherInterface $dispatcher)
    {
        $this->relationshipCreator = $relationshipCreator;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(CreateRelationshipCommand $command)
    {
        try {
            $newRelationship = $this->relationshipCreator->createRelationship($command->getUserRelationship(), $command->getDateCreated());
        } catch (RelationshipAlreadyExistsException $e) {
            return;
        }

        if ($newRelationship) {
            $event = new RelationshipEvent($newRelationship);
            $this->dispatcher->dispatch(MilioooFriendsEvents::RELATIONSHIP_CREATED, $event);
        }
    }
}
