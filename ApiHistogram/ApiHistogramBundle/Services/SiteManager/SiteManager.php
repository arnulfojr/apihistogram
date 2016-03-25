<?php

namespace ApiHistogram\ApiHistogramBundle\Services\SiteManager;


use ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface;
use ApiHistogram\ApiHistogramBundle\Services\Loader\Cleaner\CleanerLoader;
use ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\ConfigurationLoader;

/**
 * Class SiteManager
 * @package ApiHistogram\ApiHistogramBundle\Services\SiteManager
 */
class SiteManager
{
    /** @var ConfigurationLoader $configLoader */
    private $configLoader;
    /** @var CleanerLoader $cleanerLoader */
    private $cleanerLoader;
    /** @var null|array $siteCapsules */
    private $siteCapsules = NULL;
    /** @var ConfigurationInterface $sysConfig */
    private $sysConfig;

    /**
     * SiteManager constructor.
     * @param ConfigurationLoader $configurationLoader
     * @param CleanerLoader $cleanerLoader
     */
    public function __construct(ConfigurationLoader $configurationLoader, CleanerLoader $cleanerLoader)
    {
        $this->configLoader = $configurationLoader;
        $this->cleanerLoader = $cleanerLoader;
    }

    /**
     * sets up the configuration and all necessary things
     */
    public function setUp()
    {
        $this->configLoader->load();
        $this->sysConfig = $this->configLoader->getSystemConfig();
    }

    /**
     * @return ConfigurationInterface
     */
    public function getSystemConfiguration()
    {
        return $this->sysConfig;
    }

    /**
     * @return mixed
     */
    public function getSiteCapsules()
    {
        return $this->siteCapsules;
    }

    /**
     * @return array
     */
    public function getSites() // will return sites loaded and shit
    {
        $sites = $this->configLoader->getSites(); //array of SiteCapsules
        $this->siteCapsules = $sites;

        return $this->cleanerLoader->instantiate($sites);
    }

}