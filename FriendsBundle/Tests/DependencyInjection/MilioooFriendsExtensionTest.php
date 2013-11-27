<?php

/*
* This file is part of the MilioooMessageBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\MessagingBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
use Miliooo\FriendsBundle\DependencyInjection\MilioooFriendsExtension;

/**
 * Test file for MilioooMessagingExtensionTest
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class MilioooFriendsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerBuilder */
    protected $containerBuilder;

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLoadThrowsExceptionUnlessRelationshipClassSet()
    {
        $loader = new MilioooFriendsExtension();
        $config = $this->getEmptyConfig();
        unset($config['relationship_class']);
        $loader->load([$config], new ContainerBuilder());
    }

    public function testMessagingLoadModelClassesWithDefaults()
    {
        $this->createEmptyConfiguration();
        $this->assertParameter('\Acme\MyBundle\Entity\Relationship', 'miliooo_friends.relationship_class');
    }

    public function testServicesExist()
    {
        $this->createEmptyConfiguration();
        $this->assertHasDefinition('miliooo_friends.repository.relationship');
        $this->assertHasDefinition('miliooo_friends.relationship_creator');
        $this->assertHasDefinition('miliooo_friends.relationship_creator.default');
        $this->assertHasDefinition('miliooo_friends.user_relationship_provider');
        $this->assertHasDefinition('miliooo_friends.user_relationship_provider.default');
        $this->assertHasDefinition('miliooo_friends.controller.add_friends_controller');
        $this->assertHasDefinition('miliooo_friends.user_relationship_transformer');
        $this->assertHasDefinition('miliooo_friends.relationship_creator_event_aware');
        $this->assertHasDefinition('miliooo_friends.relationship_creator_event_aware.default');
    }


    protected function createEmptyConfiguration()
    {
        $this->containerBuilder = new ContainerBuilder();
        $loader = new MilioooFriendsExtension();
        $config = $this->getEmptyConfig();
        $loader->load([$config], $this->containerBuilder);
        $this->assertTrue($this->containerBuilder instanceof ContainerBuilder);
    }

    /**
     * gets an empty config
     *
     * @return array
     */
    protected function getEmptyConfig()
    {
        $yaml = <<<EOF
relationship_class: \Acme\MyBundle\Entity\Relationship
user_relationship_transformer: foo.service
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    /**
     * Asserts that a parameter key has a certain value
     *
     * @param mixed $value
     * @param string $key
     */
    private function assertParameter($value, $key)
    {
        $this->assertEquals($value, $this->containerBuilder->getParameter($key));
    }

    /**
     * Asserts that a definition exists
     *
     * @param string $id
     */
    private function assertHasDefinition($id)
    {
        $this->assertTrue(($this->containerBuilder->hasDefinition($id) || $this->containerBuilder->hasAlias($id)));
    }
}
