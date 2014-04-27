<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Miliooo\Friends\Event\MilioooFriendsEvents;
use Miliooo\Friends\Event\RelationshipEvent;
use Doctrine\Common\Cache\Cache;

/**
 * Class DoctrineCacheProviderDeleter
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DoctrineCacheProviderDeleter implements EventSubscriberInterface
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * Constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            MilioooFriendsEvents::RELATIONSHIP_CREATED => 'onRelationshipCreated',
            MilioooFriendsEvents::RELATIONSHIP_REMOVED => 'onRelationshipRemoved'
        ];
    }

    /**
     * @param RelationshipEvent $event
     */
    public function onRelationshipCreated(RelationshipEvent $event)
    {
        $this->doCacheUpdates($event);
    }

    /**
     * @param RelationshipEvent $event
     */
    public function onRelationshipRemoved(RelationshipEvent $event)
    {
        $this->doCacheUpdates($event);
    }

    /**
     * @param RelationshipEvent $event
     */
    protected function doCacheUpdates(RelationshipEvent $event)
    {
        $relationship = $event->getRelationship();
        $follower = $relationship->getFollower();
        $followed = $relationship->getFollowed();

        $this->cache->delete('miliooo_friends_provider_'.$follower->getIdentifierId());
        $this->cache->delete('miliooo_friends_provider_'.$followed->getIdentifierId());
    }
}
