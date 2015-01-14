<?php
namespace MES\APP\FrontendBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('upload');

        $rootNode
            ->children()
                ->arrayNode('auto_configure')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('twig')->defaultValue(true)->end()
                        ->booleanNode('hearsay_require_js')->defaultValue(true)->end()
                    ->end()
                ->end()
                ->arrayNode('types')
                    ->useAttributeAsKey('name')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                
                    ->prototype('array')
                        ->children()
                            ->scalarNode('adapter')->end()
                            ->scalarNode('mapping')->end()
                            ->scalarNode('file_type')->end()
                            ->arrayNode('parameters')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->end()
                                        ->scalarNode('value')->end()
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
