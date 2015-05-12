<?php

namespace OpenClassrooms\Bundle\CustomerIOBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Bastien Rambure <bastien.rambure@openclassrooms.com>
 */
class OpenClassroomsCustomerIOExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/'));
        $loader->load('services.xml');

        $config = $this->processConfiguration(new Configuration(), $config);
        $container->setParameter('openclassrooms.customer_io.site_id', $config['site_id']);
        $container->setParameter('openclassrooms.customer_io.api_key', $config['api_key']);
    }
}
