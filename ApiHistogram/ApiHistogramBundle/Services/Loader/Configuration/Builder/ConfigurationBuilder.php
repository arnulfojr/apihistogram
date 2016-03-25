<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder;


use ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface;

/**
 * Class ConfigurationBuilder
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder
 */
class ConfigurationBuilder implements ConfigurationBuilderInterface
{

    /** @var array $config */
    private $config;

    /**
     * ConfigurationBuilder constructor.
     * @param null $config
     */
    public function __construct($config = NULL)
    {
        $this->config = $config;
    }

    /**
     * @param array $config
     * @return ConfigurationBuilderInterface
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function buildSites()
    {
        $sitesConfig = $this->config["sites"];
        $sites = [];

        $siteBuilder = new SiteBuilder();

        foreach ($sitesConfig as $siteName=>$site)
        {
            $sites[$siteName] = $siteBuilder->build($site);
        }

        return $sites;
    }

    /**
     * @return ConfigurationInterface
     */
    public function buildSystemConfiguration()
    {
        $sysConfig = new SystemConfigBuilder();

        $this->config["sites"] = $this->buildSites();

        return $sysConfig->build($this->config);
    }
}