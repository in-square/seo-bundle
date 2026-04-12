<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Description of Configuration.
 *
 * @author: leogout
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('insquare_seo');
        $rootNode = $treeBuilder->getRootNode();

        $this->configureGeneralTree($rootNode);
        $this->configureBasicTree($rootNode);
        $this->configureOgTree($rootNode);
        $this->configureTwitterTree($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    protected function configureGeneralTree(ArrayNodeDefinition $rootNode): void
    {
        $generalNode = $rootNode->children()->arrayNode('general');
        $generalNode->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('title')->cannotBeEmpty()->end()
                ->scalarNode('description')->cannotBeEmpty()->end()
                ->scalarNode('image')->cannotBeEmpty()->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    protected function configureBasicTree(ArrayNodeDefinition $rootNode): void
    {
        $basicNode = $rootNode->children()->arrayNode('basic');
        $basicNode->children()
                ->scalarNode('title')->cannotBeEmpty()->end()
                ->scalarNode('description')->cannotBeEmpty()->end()
                ->scalarNode('keywords')->cannotBeEmpty()->end()
                ->arrayNode('robots')
                    ->children()
                        ->booleanNode('index')->defaultTrue()->end()
                        ->booleanNode('follow')->defaultTrue()->end()
                    ->end()
                ->end()
                ->scalarNode('canonical')->cannotBeEmpty()->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    protected function configureOgTree(ArrayNodeDefinition $rootNode): void
    {
        $ogNode = $rootNode->children()->arrayNode('og');
        $ogNode->children()
                ->scalarNode('title')->cannotBeEmpty()->end()
                ->scalarNode('description')->cannotBeEmpty()->end()
                ->scalarNode('image')->cannotBeEmpty()->end()
                ->scalarNode('type')->cannotBeEmpty()->end()
                ->scalarNode('url')->cannotBeEmpty()->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    protected function configureTwitterTree(ArrayNodeDefinition $rootNode): void
    {
        $twitterNode = $rootNode->children()->arrayNode('twitter');
        $twitterNode->children()
                ->scalarNode('title')->cannotBeEmpty()->end()
                ->scalarNode('description')->cannotBeEmpty()->end()
                ->scalarNode('image')->cannotBeEmpty()->end()
                ->scalarNode('card')->cannotBeEmpty()->end()
                ->scalarNode('site')->cannotBeEmpty()->end()
            ->end();
    }

}
