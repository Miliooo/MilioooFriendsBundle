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
     * Constructor.
     *
     * @param RelationshipCreatorInterface $relationshipCreator
     */
    public function __construct(RelationshipCreatorInterface $relationshipCreator)
    {
        $this->relationshipCreator = $relationshipCreator;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(CreateRelationshipCommand $command)
    {
        $this->relationshipCreator->createRelationship($command->getUserRelationship(), $command->getDateCreated());
    }
}
