<?php

namespace ApiHistogram\ApiHistogramBundle\Container\Configuration;

/**
 * Class Configuration
 * @package ApiHistogram\ApiHistogramBundle\Container\Configuration
 */
class Configuration implements ConfigurationInterface
{
    /** @var string $connectionName */
    private $connectionName;
    /** @var string $schemaName */
    private $schemaName;
    /** @var array $sites */
    private $sites; // returns an array containing instances of SiteCapsule

    /**
     * @return string
     */
    public function getConnectionName()
    {
        return $this->connectionName;
    }

    /**
     * @param string $connectionName
     */
    public function setConnectionName($connectionName)
    {
        $this->connectionName = $connectionName;
    }

    /**
     * @return string
     */
    public function getSchemaName()
    {
        return $this->schemaName;
    }

    /**
     * @param string $schemaName
     */
    public function setSchemaName($schemaName)
    {
        $this->schemaName = $schemaName;
    }

    /**
     * @return array
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * @param array $sites
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
    }

}