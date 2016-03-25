<?php

namespace ApiHistogram\ApiHistogramBundle\Container\Configuration\Database;

use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Exception\InvalidArgumentException;

/**
 * Class DatabaseConfiguration
 * @package ApiHistogram\ApiHistogramBundle\Container\Configuration\Database
 */
class DatabaseConfiguration implements DatabaseConfigurationInterface
{
    /** @var string $tableName */
    private $tableName;
    /** @var boolean $createTable */
    private $createTable = false;

    /**
     *
     * Returns the name of the table in the Schema to save the response in
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     *
     * Sets the name of the Table Name to save the response information
     *
     * @param string $tableName
     * @return DatabaseConfigurationInterface
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     *
     * Returns a boolean value if the Table has not been created yet
     *
     * @return boolean
     */
    public function willCreateTable()
    {
        return $this->createTable;
    }

    /**
     * @param bool $condition
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setCreateTable($condition)
    {
        if (is_bool($condition))
        {
            $this->createTable = $condition;

            return $this;
        }

        $exception = new InvalidArgumentException(
            "Invalid argument passed to DatabaseConfiguration",
            ExceptionParameters::INVALID_ARGUMENT_CODE
        );

        $exception->setActualClassName(get_class($condition));
        $exception->setExpectedClassName("bool");

        throw $exception;
    }
}