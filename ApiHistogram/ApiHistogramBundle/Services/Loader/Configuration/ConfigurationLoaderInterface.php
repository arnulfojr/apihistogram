<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface;

/**
 * Interface ConfigurationLoaderInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration
 */
interface ConfigurationLoaderInterface
{
    /**
     * @return array
     * Returns an array of SiteContainerInterface
     */
    public function getSites();

    /**
     * @return array
     * Returns the normal configuration
     */
    public function getConfig(); // raw config

    /**
     * @return ConfigurationInterface
     */
    public function getSystemConfig();

    /**
     * @return null
     */
    public function load();

}