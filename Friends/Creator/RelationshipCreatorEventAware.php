<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Creator;

use Miliooo\Friends\ValueObjects\UserRelationship;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Miliooo\Friends\Event\MilioooFriendsEvents;
use Miliooo\Friends\Event\NewRelationshipEvent;

/**
 * Class RelationshipCreatorEventAware
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class RelationshipCreatorEventAware implements RelationshipCreatorInterface
{
    /**
     * A relationship creator instance.
     *
     * @var RelationshipCreatorInterface
     */
    private $creator;

    /**
     * An event dispatcher instance.
     *
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * Constructor.
     *
     * @param RelationshipCreatorInterface $creator    A relationship creator instance
     * @param EventDispatcherInterface     $dispatcher An event dispatcher instance
     */
    public function __construct(RelationshipCreatorInterface $creator, EventdispatcherInterface $dispatcher)
    {
        $this->creator = $creator;
        $this->dispatcher = $dispatcher;
    }

    /**
     *{@inheritDoc}
     */
    public function createRelationship(UserRelationship $userRelationship, \DateTime $dateCreated)
    {
        $relationship = $this->creator->createRelationship($userRelationship, $dateCreated);

        $event = new NewRelationshipEvent($relationship);
        $this->dispatcher->dispatch(MilioooFriendsEvents::RELATIONSHIP_CREATED, $event);

        return $relationship;
    }
}
