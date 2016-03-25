<?php

namespace ApiHistogram\ApiHistogramBundle\Container\Configuration;

use ApiHistogram\ApiHistogramBundle\Cleaners\CleanerInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\Database\DatabaseConfigurationInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\URL\URLContainerInterface;

/**
 * Interface SiteCapsuleInterface
 * @package ApiHistogram\ApiHistogram\ApiHistogramBundle\Container
 * Contain the data from the Sites
 */
interface SiteCapsuleInterface
{
    /**
     * @deprecated Use DatabaseConfigurationInterface instead
     * @return string
     */
    public function getTableName();

    /**
     * @deprecated Use DatabaseConfigurationInterface instead
     * @param string $tableName
     * @return SiteCapsuleInterface
     */
    public function setTableName($tableName);

    /**
     * @param string $name
     * @return SiteCapsuleInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param URLContainerInterface $url
     * @return SiteCapsuleInterface
     */
    public function setURL(URLContainerInterface $url);

    /**
     * @return URLContainerInterface
     */
    public function getURL();

    /**
     * @param string $formatterName
     * @return SiteCapsuleInterface
     */
    public function setFormatterName($formatterName);

    /**
     * @return string
     */
    public function getFormatterName();

    /**
     * @param CleanerInterface $cleanerInterface
     * @return SiteCapsuleInterface
     */
    public function setCleaner(CleanerInterface $cleanerInterface);

    /**
     * @return CleanerInterface
     */
    public function getCleaner();

    /**
     * @deprecated Use DatabaseConfigurationInterface instead
     * @param boolean $condition
     * @return SiteCapsuleInterface
     */
    public function setCreateTable($condition);

    /**
     * @return boolean
     * @deprecated Use DatabaseConfigurationInterface instead
     */
    public function willCreateTable();

    /**
     * @param DatabaseConfigurationInterface $configuration
     * @return SiteCapsuleInterface
     */
    public function setDatabaseConfiguration(DatabaseConfigurationInterface $configuration);

    /**
     * @return DatabaseConfigurationInterface
     */
    public function getDatabaseConfiguration();

}