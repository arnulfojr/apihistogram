<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\Database\DatabaseConfiguration;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsule;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\URL\URL;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Exception\Loader\LoaderException;

/**
 * Class SiteBuilder
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder
 */
class SiteBuilder implements BuilderInterface
{
    const SITE_NAME_KEY = "name"; // key to use for the name field
    const SITE_FORMATTER_KEY = "formatter"; // key to use for the formatter field
    const SITE_URL_KEY = "url"; // key to use for the url field
    const SITE_DATABASE_KEY = "database"; // key to use for the database field
    const SITE_DATABASE_TABLE_NAME_KEY = "table_name";
    const SITE_DATABASE_CREATE_TABLE_KEY = "create_table";

    /**
     * @param array $options
     * @return SiteCapsuleInterface
     */
    public function build($options = NULL)
    {
        $site = $this->buildSite($options);

        $dbOptions = $options[SiteBuilder::SITE_DATABASE_KEY];

        $url = $this->buildURL($options);
        $config = $this->buildDatabaseConfiguration($dbOptions);

        $site->setURL($url);
        $site->setDatabaseConfiguration($config);

        return $site;
    }

    /**
     * @param array $options
     * @throws LoaderException
     * @return SiteCapsule
     */
    protected function buildSite(array $options)
    {
        $site = new SiteCapsule();

        $necessaryKeys = $this->getNecessaryFields();

        if (!$this->keysExist($necessaryKeys, $options))
        {
            throw new LoaderException(
                ExceptionParameters::getValueNotPresent("the core fields must be defined"),
                ExceptionParameters::VALIDATOR_VALUE_NOT_PRESENT_CODE
            );
        }

        $site->setFormatterName($options[SiteBuilder::SITE_FORMATTER_KEY]);
        $site->setName($options[SiteBuilder::SITE_NAME_KEY]);

        // TODO: deprecated
        $dbOptions = $options[SiteBuilder::SITE_DATABASE_KEY];

        if (!$this->keyExists(SiteBuilder::SITE_DATABASE_TABLE_NAME_KEY, $dbOptions))
        {
            throw new LoaderException(
                ExceptionParameters::getValueNotPresent("the table_name must be defined"),
                ExceptionParameters::VALIDATOR_VALUE_NOT_PRESENT_CODE
            );
        }

        $site->setTableName($dbOptions[SiteBuilder::SITE_DATABASE_TABLE_NAME_KEY]);

        if ($this->keyExists(SiteBuilder::SITE_DATABASE_CREATE_TABLE_KEY, $dbOptions))
        {
            $site->setCreateTable($dbOptions[SiteBuilder::SITE_DATABASE_CREATE_TABLE_KEY]);
        }

        return $site;
    }

    /**
     * @param array $options
     * @return URL
     * @throws LoaderException
     */
    protected function buildURL(array $options)
    {
        $url = new URL();

        if (!$this->keyExists(SiteBuilder::SITE_URL_KEY, $options))
        {
            throw new LoaderException(
                ExceptionParameters::getValueNotPresent("the url field must be defined"),
                ExceptionParameters::VALIDATOR_VALUE_NOT_PRESENT_CODE
            );
        }

        $url->setUrl($options[SiteBuilder::SITE_URL_KEY]);

        return $url;
    }

    /**
     * @param array $dbOptions
     * @throws LoaderException
     * @return DatabaseConfiguration
     */
    protected function buildDatabaseConfiguration(array $dbOptions)
    {
        $config = new DatabaseConfiguration();

        if (!$this->keyExists(SiteBuilder::SITE_DATABASE_TABLE_NAME_KEY, $dbOptions))
        {
            throw new LoaderException(
                ExceptionParameters::getValueNotPresent("the table_name must be defined"),
                ExceptionParameters::VALIDATOR_VALUE_NOT_PRESENT_CODE
            );
        }

        $config->setTableName($dbOptions[SiteBuilder::SITE_DATABASE_TABLE_NAME_KEY]);

        if ($this->keyExists(SiteBuilder::SITE_DATABASE_CREATE_TABLE_KEY, $dbOptions))
        {
            $config->setCreateTable(boolval($dbOptions[SiteBuilder::SITE_DATABASE_CREATE_TABLE_KEY]));
        }

        return $config;
    }

    /**
     * @param array $keys
     * @param array $array
     * @return bool
     */
    private function keysExist(array $keys, array $array)
    {
        foreach ($keys as $key)
        {
            if (!$this->keyExists($key, $array))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $key
     * @param array $array
     * @return bool
     */
    private function keyExists($key, array $array)
    {
        return array_key_exists($key, $array);
    }

    /**
     * @return array
     */
    static public function getNecessaryFields()
    {
        return [
            SiteBuilder::SITE_FORMATTER_KEY,
            SiteBuilder::SITE_NAME_KEY,
            SiteBuilder::SITE_DATABASE_KEY
        ];
    }

}