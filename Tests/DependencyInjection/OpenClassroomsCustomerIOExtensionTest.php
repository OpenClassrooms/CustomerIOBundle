<?php

namespace Tests\DependencyInjection;

use OpenClassrooms\Bundle\CustomerIOBundle\DependencyInjection\OpenClassroomsCustomerIOExtension;
use OpenClassrooms\Bundle\CustomerIOBundle\OpenClassroomsCustomerIOBundle;
use OpenClassrooms\CustomerIO\Client;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Bastien Rambure <bastien.rambure@openclassrooms.com>
 */
class OpenClassroomsCustomerIOExtensionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ExtensionInterface
     */
    private $extension;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var YamlFileLoader
     */
    private $configLoader;

    /**
     * @test
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function NoConfiguration_ThrowException()
    {
        $this->configLoader->load('empty_config.yml');
        $this->container->compile();
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function WithoutSiteIdConfiguration_ThrowException()
    {
        $this->configLoader->load('without_site_id_config.yml');
        $this->container->compile();
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function WithoutApiKeyConfiguration_ThrowException()
    {
        $this->configLoader->load('without_api_key_config.yml');
        $this->container->compile();
    }

    /**
     * @test
     */
    public function Configuration()
    {
        $expectedSiteId = 'site-id';
        $expectedApiKey = 'api-key';
        $this->configLoader->load('config.yml');
        $this->container->compile();

        /** @var Client $client */
        $client = $this->container->get('openclassrooms.customer_io.guzzle_client');

        $rc = new \ReflectionClass($client);
        $rp = $rc->getProperty('guzzle');
        $rp->setAccessible(true);
        /** @var \Guzzle\Http\Client $guzzle */
        $guzzle = $rp->getValue($client);

        $this->assertEquals(array($expectedSiteId, $expectedApiKey), $guzzle->getConfig('auth'));
    }

    /**
     * @test
     */
    public function assertCustomerService()
    {
        $this->configLoader->load('config.yml');
        $this->container->compile();
        $this->assertTrue($this->container->has('openclassrooms.customer_io.services.customer_service'));
    }

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new OpenClassroomsCustomerIOExtension();
        $this->container->registerExtension($this->extension);
        $this->container->loadFromExtension('open_classrooms_customer_io');
        $this->configLoader = new YamlFileLoader(
            $this->container,
            new FileLocator(__DIR__ . '/Fixtures/Resources/config')
        );
        $bundle = new OpenClassroomsCustomerIOBundle();
        $bundle->build($this->container);
    }
}
