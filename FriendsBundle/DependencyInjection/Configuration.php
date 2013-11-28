<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('miliooo_friends');

        $rootNode
            ->children()
            ->scalarNode('relationship_class')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('user_relationship_transformer')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('relationship_creator')->defaultValue('miliooo_friends.relationship_creator.default')->cannotBeEmpty()->end()
            ->scalarNode('relationship_creator_event_aware')->defaultValue('miliooo_friends.relationship_creator_event_aware.default')->cannotBeEmpty()->end()
            ->scalarNode('logged_in_user_provider')->defaultValue('miliooo_friends.logged_in_user_provider.default')->cannotBeEmpty()->end()
            ->arrayNode('deleter')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('relationship_deleter')->defaultValue('miliooo_friends.deleter.relationship_deleter.default')->cannotBeEmpty()->end()
                    ->scalarNode('relationship_deleter_secure_aware')->defaultValue('miliooo_friends.deleter.relationship_deleter_secure_aware.default')->cannotBeEmpty()->end()
                ->end()
            ->end()
            ->arrayNode('specifications')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('can_delete_relationship')->defaultValue('miliooo_friends.specifications.can_delete_relationship.default')->cannotBeEmpty()->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
