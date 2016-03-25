<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder;


use ApiHistogram\ApiHistogramBundle\Container\Configuration\Configuration;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface;

/**
 * Class SystemConfigBuilder
 * @package ApiHistogramBundle\Services\Loader\Configuration\Builder
 */
class SystemConfigBuilder implements BuilderInterface
{
    /**
     * @param array $options
     * @return ConfigurationInterface
     */
    public function build($options = NULL)
    {
        $config = new Configuration();

        $config->setConnectionName($options["connection"]);
        $config->setSchemaName($options["schema_name"]);
        $config->setSites($options["sites"]);

        return $config;
    }
}