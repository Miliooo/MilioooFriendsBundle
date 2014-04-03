<?php

/*
* This file is part of the MilioooMessageBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MilioooFriendsExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('command.xml');
        $loader->load('controllers.xml');
        $loader->load('deleter.xml');
        $loader->load('services.xml');
        $loader->load('specifications.xml');

        $container->setParameter('miliooo_friends.relationship_class', $config['relationship_class']);
        $container->setAlias('miliooo_friends.relationship_creator', $config['relationship_creator']);
        $container->setAlias('miliooo_friends.logged_in_user_provider', $config['logged_in_user_provider']);
        $container->setAlias('miliooo_friends.user_relationship_transformer', $config['user_relationship_transformer']);
        $container->setAlias('miliooo_friends.relationship_creator_event_aware', $config['relationship_creator_event_aware']);
        $this->setDeleterAliases($container, $config);
        $container->setAlias('miliooo_friends.specifications.can_delete_relationship', $config['specifications']['can_delete_relationship']);
        $container->setAlias('miliooo_friends.user_relationships_provider', $config['user_relationships_provider']);
        $container->setAlias('miliooo_friends.twig_extension', $config['twig_extension']);

        $container->setAlias('miliooo_friends.handler.create_relationship', $config['handler']['create_relationship']);
    }

    /**
     * Sets the deleter aliases.
     *
     * @param ContainerBuilder $container The container instance
     * @param array            $config    The processed config
     */
    protected function setDeleterAliases(ContainerBuilder $container, $config)
    {
        $container->setAlias('miliooo_friends.deleter.relationship_deleter', $config['deleter']['relationship_deleter']);
        $container->setAlias('miliooo_friends.deleter.relationship_deleter_secure_aware', $config['deleter']['relationship_deleter_secure_aware']);
    }
}
