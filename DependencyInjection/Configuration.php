<?php

namespace PedroTeixeira\Bundle\GridBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pedro_teixeira_grid');

        $rootNode
            ->children()
                ->arrayNode('defaults')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('currency')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('locale')
                                    ->defaultValue('en')
                                ->end()
                                ->scalarNode('currency')
                                    ->defaultValue('EUR')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('date')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('use_datepicker')
                                    ->defaultValue(true)
                                ->end()
                                ->scalarNode('date_format')
                                    ->defaultValue('dd/MM/yy')
                                ->end()
                                ->scalarNode('date_time_format')
                                    ->defaultValue('dd/MM/yy HH:mm:ss')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('pagination')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('limit')
                                    ->defaultValue(20)
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('export')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('enabled')
                                        ->defaultValue(true)
                                    ->end()
                                    ->scalarNode('path')
                                        ->defaultValue('/tmp/')
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
