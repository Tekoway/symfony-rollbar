<?php

namespace Tekoway\Rollbar\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration class
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tekoway');

        $allowedErrorLevels = [
            'E_ERROR',
            'E_WARNING',
            'E_PARSE',
            'E_CORE_ERROR',
            'E_CORE_WARNING',
            'E_COMPILE_ERROR',
            'E_COMPILE_WARNING',
            'E_USER_ERROR',
            'E_USER_WARNING',
            'E_USER_NOTICE',
            'E_STRICT',
            'E_RECOVERABLE_ERROR',
            'E_DEPRECATED',
            'E_USER_DEPRECATED',
            'E_ALL'
        ];

        $rootNode
            ->children()
                ->scalarNode('access_token')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->end()
                ->scalarNode('environment')
                    ->defaultValue('%kernel.environment%')
                    ->end()
                ->arrayNode('error_levels')
                    ->treatNullLike(array('E_ALL'))
                    ->prototype('scalar')
                        ->validate()
                            ->ifTrue(function ($v) use ($allowedErrorLevels){ 
                                return !in_array($v, $allowedErrorLevels); 
                            })
                            ->thenInvalid('Invalid value, allowed values are: "'.implode($allowedErrorLevels, '", "').'"')
                            ->end()
                        ->end()
                    ->end()
                ->booleanNode('enabled')
                    ->defaultValue(false)
                    ->end()
                ->arrayNode('exceptions_ignore_list')
                    ->prototype('scalar')
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
