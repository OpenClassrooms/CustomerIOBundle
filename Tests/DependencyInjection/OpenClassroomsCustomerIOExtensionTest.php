<?php

namespace Tests\DependencyInjection;

use OpenClassrooms\Bundle\CustomerIOBundle\DependencyInjection\OpenClassroomsCustomerIOExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Bastien Rambure <bastien.rambure@openclassrooms.com>
 */
class OpenClassroomsCustomerIOExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @test
     */
    public function assertCatalogService()
    {
        $this->container = new ContainerBuilder();
        $extension = new OpenClassroomsCustomerIOExtension();
        $this->container->registerExtension($extension);

        $extension->load(array(), $this->container);

        $this->assertTrue($this->container->has('openclassrooms.customer_io.services.customer_service'));
    }
}
