<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Command\Handler;

use Miliooo\Friends\Command\CreateRelationshipCommand;

/**
 * Handler responsible for handling create relationship commands.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
interface CreateRelationshipCommandHandlerInterface
{
    /**
     * @param CreateRelationshipCommand $command
     */
    public function handle(CreateRelationshipCommand $command);
}
