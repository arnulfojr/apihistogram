<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Configuration;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\Configuration;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\Database\DatabaseConfiguration;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsule;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\URL\URL;

/**
 * Class ConfigurationVariables
 * @package ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Configuration
 */
class ConfigurationVariables
{

    const CONFIGURATION_BUILDER_CLASS = 'ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder\ConfigurationBuilder';

    /**
     * @return array
     */
    public static function getConfig()
    {
        return [
            "connection"=>"default",
            "schema_name"=>"api_histogram",
            "sites"=>[
                "currency"=>[
                    "name"=>"Currency",
                    "url"=>"http://www.google.com",
                    "formatter"=>'ApiHistogram\ApiHistogram\Formatter\Class',
                    "database"=>[
                        "table_name"=>"currency",
                        "create_table"=>true
                    ]
                ],
                "stocks"=>[
                    "name"=>"Stocks",
                    "url"=>"http://www.yahoo.com",
                    "formatter"=>'ApiHistogram\ApiHistogram\Formatter\AnotherClass',
                    "database"=>[
                        "table_name"=>"stocks",
                        "create_table"=>false
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public static function getSitesConfig()
    {
        return ConfigurationVariables::getConfig()["sites"];
    }

    /**
     * @return array
     */
    public static function getSiteCapsules()
    {
        $toReturn = [];

        $sites = ConfigurationVariables::getSitesConfig();

        foreach($sites as $name=>$site)
        {
            $web = new SiteCapsule();
            $url = new URL();
            $dbConfig = new DatabaseConfiguration();

            $web->setFormatterName($site["formatter"]);
            $web->setTableName($site["database"]["table_name"]);
            $web->setCreateTable($site["database"]["create_table"]);
            $web->setName($site["name"]);

            $url->setUrl($site["url"]);

            $dbConfig->setCreateTable($site["database"]["create_table"]);
            $dbConfig->setTableName($site["database"]["table_name"]);

            $web->setURL($url);
            $web->setDatabaseConfiguration($dbConfig);

            $toReturn[$name] = $web;
        }

        return $toReturn;
    }

    /**
     * @return Configuration
     */
    public static function getSystemConfig()
    {
        $config = new Configuration();
        $config->setSites(ConfigurationVariables::getSiteCapsules());
        $config->setConnectionName(ConfigurationVariables::getConfig()["connection"]);
        $config->setSchemaName(ConfigurationVariables::getConfig()["schema_name"]);

        return $config;
    }

}