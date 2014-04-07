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


/**
 * Handler responsible for handling the delete relationship command.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface DeleteRelationshipCommandHandlerInterface
{
    /**
     * Handles the deleting of an relationship
     *
     * @param DeleteRelationshipCommand $command
     */
    public function handle(DeleteRelationshipCommand $command);
}
