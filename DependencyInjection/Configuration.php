<?php
namespace OpenClassrooms\Bundle\CustomerIOBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('open_classrooms_customer_io');
        $rootNode->children()
            ->scalarNode('site_id')->isRequired()->end()
            ->scalarNode('api_key')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
