<?php

namespace ApiHistogram\ApiHistogramBundle\Container\Configuration;

use ApiHistogram\ApiHistogramBundle\Cleaners\CleanerInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\Database\DatabaseConfigurationInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\URL\URLContainerInterface;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use \InvalidArgumentException;

/**
 * Class SiteCapsule
 * @package ApiHistogram\ApiHistogramBundle\Container\Configuration
 */
class SiteCapsule implements SiteCapsuleInterface
{
    /** @var string $tableName */
    private $tableName;
    /** @var string $name */
    private $name;
    /** @var URLContainerInterface $url */
    private $url;
    /** @var string $formatter */
    private $formatter;
    /** @var null|CleanerInterface $cleaner */
    private $cleaner = NULL;
    /** @var bool $createTable */
    private $createTable = false;
    /** @var null|DatabaseConfigurationInterface $databaseConfiguration */
    private $databaseConfiguration = NULL;

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     * @return SiteCapsuleInterface
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @param string $name
     * @return SiteCapsuleInterface
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param URLContainerInterface $url
     * @return SiteCapsuleInterface
     */
    public function setURL(URLContainerInterface $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return URLContainerInterface
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * @param string $formatterName
     * @return SiteCapsuleInterface
     */
    public function setFormatterName($formatterName)
    {
        $this->formatter = $formatterName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormatterName()
    {
        return $this->formatter;
    }

    /**
     * @param CleanerInterface $cleanerInterface
     * @return SiteCapsuleInterface
     */
    public function setCleaner(CleanerInterface $cleanerInterface)
    {
        $this->cleaner = $cleanerInterface;

        return $this;
    }

    /**
     * @return CleanerInterface
     */
    public function getCleaner()
    {
        return $this->cleaner;
    }

    /**
     * @param boolean $condition
     * @return SiteCapsuleInterface
     */
    public function setCreateTable($condition)
    {
        if (is_bool($condition))
        {
            $this->createTable = $condition;
            return $this;
        }

        $givenClass = get_class($condition);

        throw new InvalidArgumentException(
            "Expected a boolean value at SiteCapsule's setCreateTable method, got {$givenClass} instead",
            ExceptionParameters::INVALID_ARGUMENT_CODE
        );
    }

    /**
     * @return boolean
     */
    public function willCreateTable()
    {
        return $this->createTable;
    }

    /**
     * @param DatabaseConfigurationInterface $configuration
     * @return SiteCapsuleInterface
     */
    public function setDatabaseConfiguration(DatabaseConfigurationInterface $configuration)
    {
        $this->databaseConfiguration = $configuration;

        return $this;
    }

    /**
     * @return DatabaseConfigurationInterface
     */
    public function getDatabaseConfiguration()
    {
        return $this->databaseConfiguration;
    }
}