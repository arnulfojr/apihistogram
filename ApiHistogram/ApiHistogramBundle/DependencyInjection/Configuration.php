<?php

namespace ApiHistogram\ApiHistogramBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    const SITES_INFO = "List of sites to fetch the API";
    const CONNECTION_NAME_INFO = "Name of the doctrine connection to use";
    const SCHEMA_NAME_INFO = "Name of the schema to use in the database";

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('api_histogram');

        // load the tree
        $rootNode
            ->children()
                ->scalarNode('schema_name')
                    ->info(Configuration::SCHEMA_NAME_INFO)
                ->end()
                ->scalarNode('connection')
                    ->info(Configuration::CONNECTION_NAME_INFO)
                ->end()
                ->arrayNode('sites')
                    ->info(Configuration::SITES_INFO)
                    ->prototype('variable')
                ->end()
            ->end()
            ;
        return $treeBuilder;
    }
}
