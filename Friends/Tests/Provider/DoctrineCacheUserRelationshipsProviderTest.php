<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\Friends\Tests\Provider;

use Miliooo\Friends\Provider\DoctrineCacheUserRelationshipsProvider;

/**
 * Test file for Miliooo\Friends\Provider\DoctrineCacheUserRelationshipsProvider
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class DoctrineCacheUserRelationshipsProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DoctrineCacheUserRelationshipsProvider
     */
    private $cacheProvider;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $cache;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $provider;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $userRelationship;

    public function setUp()
    {
        $this->cache = $this->getMock('Doctrine\Common\Cache\Cache');
        $this->provider = $this->getMock('Miliooo\Friends\Provider\UserRelationshipsProviderInterface');
        $this->cacheProvider = new DoctrineCacheUserRelationshipsProvider($this->cache, $this->provider);
        $this->userRelationship = $this->getMock('Miliooo\Friends\User\UserRelationshipInterface');
    }

    public function testInterface()
    {
        $this->assertInstanceOf('Miliooo\Friends\Provider\UserRelationshipsProviderInterface', $this->cacheProvider);
    }

    public function test_get_user_relationship_with_cache_false()
    {
        $this->userRelationship->expects($this->once())->method('getUserRelationshipId')->will($this->returnValue(5));

        $this->cache->expects($this->once())->method('fetch')->with('miliooo_friends_provider_5')
            ->will($this->returnValue(false));

        $this->provider->expects($this->once())->method('getUserRelationships')->with($this->userRelationship)
        ->will($this->returnValue('foo'));

        $this->cache->expects($this->once())->method('save')->with('miliooo_friends_provider_5', 'foo');

        $result = $this->cacheProvider->getUserRelationships($this->userRelationship);
        $this->assertSame('foo', $result);
    }

    public function test_get_user_relationship_with_cache()
    {
        $this->userRelationship->expects($this->once())->method('getUserRelationshipId')->will($this->returnValue(5));

        $this->cache->expects($this->once())->method('fetch')->with('miliooo_friends_provider_5')
            ->will($this->returnValue('foo'));

        $this->provider->expects($this->never())->method('getUserRelationships');

        $result = $this->cacheProvider->getUserRelationships($this->userRelationship);
        $this->assertSame('foo', $result);
    }
}
