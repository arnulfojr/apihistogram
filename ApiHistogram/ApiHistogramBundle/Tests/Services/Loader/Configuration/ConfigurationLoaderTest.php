<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Configuration;

use ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder\ConfigurationBuilder;
use ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\ConfigurationLoader;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * Class ConfigurationLoaderTest
 * @package ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Configuration
 */
class ConfigurationLoaderTest extends TestCase
{
    /** @var array $config */
    private $config;
    /** @var null|ConfigurationLoader $loader */
    private $loader = NULL;


    public function setUp()
    {
        parent::setUp();

        $this->config = ConfigurationVariables::getConfig();
    }


    /**
     * Data provider is defined in the ConfigurationVariables Class
     */
    public function testLoad()
    {
        $configBuilderMock = $this->prophesize(ConfigurationVariables::CONFIGURATION_BUILDER_CLASS);

        /** @var ConfigurationBuilder $configBuilder */
        $configBuilder = $configBuilderMock->reveal();

        // config
        $configBuilderMock
            ->setConfig($this->config)
            ->shouldBeCalled();
        $configBuilderMock
            ->buildSites()
            ->willReturn(ConfigurationVariables::getSiteCapsules());
        $configBuilderMock
            ->buildSystemConfiguration()
            ->willReturn(ConfigurationVariables::getSystemConfig());

        $this->loader = new ConfigurationLoader($configBuilder, $this->config);

        $this->loader->load();

        $this->assertEquals(ConfigurationVariables::getSiteCapsules(), $this->loader->getSites());
        $this->assertEquals(ConfigurationVariables::getSystemConfig(), $this->loader->getSystemConfig());

    }

}