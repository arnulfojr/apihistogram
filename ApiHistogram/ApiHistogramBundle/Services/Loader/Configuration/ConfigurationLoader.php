<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface;
use ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder\ConfigurationBuilderInterface;

/**
 * Class ConfigurationLoader
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration
 */
class ConfigurationLoader implements ConfigurationLoaderInterface
{
    /** @var ConfigurationBuilderInterface $configurationBuilder */
    private $configurationBuilder;

    /** @var array $config */
    private $config; // configurations directly from the YML loader

    /** @var ConfigurationInterface|null $systemConfig */
    private $systemConfig = NULL;

    /** @var array|null $sites */
    private $sites = NULL;

    /**
     * ConfigurationLoader constructor.
     * @param ConfigurationBuilderInterface $configurationBuilder
     * @param array $config
     */
    public function __construct(ConfigurationBuilderInterface $configurationBuilder, array $config)
    {
        $this->configurationBuilder = $configurationBuilder;
        $this->config = $config;
    }

    /**
     * @return array
     * Returns an array of SiteContainerInterface
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @return array
     * Returns the normal configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return ConfigurationInterface
     */
    public function getSystemConfig()
    {
        return $this->systemConfig;
    }

    /**
     *
     * Loads the SiteCapsules and the SystemConfiguration
     * Access them through the getter and setters
     *
     */
    public function load()
    {
        $this->configurationBuilder->setConfig($this->config);

        $this->sites = $this->configurationBuilder->buildSites();
        $this->systemConfig = $this->configurationBuilder->buildSystemConfiguration();
    }
}