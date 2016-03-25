<?php

namespace ApiHistogram\ApiHistogramBundle\Container\Configuration\Database;

/**
 *
 * Defines the structure of the information saved regarding to the Database
 *
 * Interface DatabaseConfigurationInterface
 * @package ApiHistogram\ApiHistogramBundle\Container\Configuration\Database
 */
interface DatabaseConfigurationInterface
{
    /**
     *
     * Returns the name of the table in the Schema to save the response in
     *
     * @return string
     */
    public function getTableName();

    /**
     *
     * Sets the name of the Table Name to save the response information
     *
     * @param string $tableName
     * @return DatabaseConfigurationInterface
     */
    public function setTableName($tableName);

    /**
     *
     * Returns a boolean value if the Table has not been created yet
     *
     * @return boolean
     */
    public function willCreateTable();

    /**
     * @param boolean $condition
     * @return DatabaseConfigurationInterface
     */
    public function setCreateTable($condition);
}