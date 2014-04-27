<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Provider;

use Miliooo\Friends\Model\UserRelationships;
use Miliooo\Friends\User\UserIdentifierInterface;
use Doctrine\Common\Cache\Cache;

/**
 * Doctrine cache proxy.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DoctrineCacheUserRelationshipsProvider implements UserRelationshipsProviderInterface
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var UserRelationshipsProviderInterface
     */
    private $provider;

    /**
     * @param Cache                              $cache
     * @param UserRelationshipsProviderInterface $provider
     */
    public function __construct(Cache $cache, UserRelationshipsProviderInterface $provider)
    {
        $this->cache = $cache;
        $this->provider = $provider;
    }

    /**
     * Gets the user relationships.
     *
     * @param UserIdentifierInterface $user The user for whom we get the relationships.
     *
     * @return UserRelationships An user relationships object.
     */
    public function getUserRelationships(UserIdentifierInterface $user)
    {
        $key = $this->getCacheKey($user);
        $cachedDate = $this->cache->fetch($key);

        if ($cachedDate !== false) {
            return $cachedDate;
        }

        $data = $this->provider->getUserRelationships($user);
        $this->cache->save($key, $data);

        return $data;
    }

    /**
     * Returns the cache key we use for storing and retrieving the cache.
     *
     * @param UserIdentifierInterface $user
     *
     * @return string
     */
    protected function getCacheKey(UserIdentifierInterface $user)
    {
        return 'miliooo_friends_provider_'.$user->getIdentifierId();
    }
}
