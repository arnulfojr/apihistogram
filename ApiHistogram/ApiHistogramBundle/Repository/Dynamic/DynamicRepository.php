<?php

namespace ApiHistogram\ApiHistogramBundle\Repository\Dynamic;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Exception\Persist\PersistException;
use ApiHistogram\ApiHistogramBundle\Exception\Repository\RepositoryException;
use ApiHistogram\ApiHistogramBundle\Services\SiteManager\SiteManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Table;

/**
 * Class DynamicRepository
 * @package ApiHistogram\ApiHistogramBundle\Repository\Dynamic
 */
class DynamicRepository extends DynamicEntityManager
{
    /** @var SiteManager $siteManager */
    private $siteManager;

    /**
     * DynamicRepository constructor.
     * @param Registry $doctrine
     * @param SiteManager $siteManager
     */
    public function __construct(Registry $doctrine, SiteManager $siteManager)
    {
        parent::__construct($doctrine);

        $this->siteManager = $siteManager;
    }


    /**
     * @param SiteCapsuleInterface $capsule
     * @param array $parameters
     * @return int
     * @throws RepositoryException
     */
    public function executeInsertSQL(SiteCapsuleInterface $capsule, array $parameters)
    {
        try
        {
            $sysConfig = $this->siteManager->getSystemConfiguration();

            $this->setUp($sysConfig->getConnectionName());

            $connection = $this->getConnection();

            // Set schema.tableName to save in
            $tableExpression = $this->getTableExpression($capsule, $sysConfig);

            if ($capsule->getDatabaseConfiguration()->willCreateTable())
            {
                $this->createTable($capsule, $parameters);
            }

            return $connection->insert($tableExpression, $parameters);
        }
        catch (RepositoryException $e)
        {

            throw new RepositoryException(
                $e->getMessage(),
                ExceptionParameters::EXECUTE_INSERT_ENTITY_MANAGER_NULL_CODE,
                $e
            );
        }
        catch (DBALException $e)
        {
            throw new RepositoryException(
                ExceptionParameters::getExecuteInsertDBALException($e->getMessage()),
                ExceptionParameters::EXECUTE_INSERT_DBAL_EXCEPTION_CODE,
                $e
            );
        }
    }

    /**
     * Creates Table needed to persist the wished response
     * @param SiteCapsuleInterface $capsule
     * @param array $parameters
     * @throws PersistException
     */
    protected function createTable(SiteCapsuleInterface $capsule, array $parameters)
    {
        if ($this->tableExists($capsule))
        {
            return;
        }

        $connection = $this->getConnection();
        /** @var AbstractSchemaManager $schemaManager */
        $schemaManager = $connection->getSchemaManager();

        $table = $this->buildTable($capsule, $parameters);

        $schemaManager->createTable($table);
    }


    /**
     * @param SiteCapsuleInterface $capsule
     * @param array $parameters
     * @return Table
     * @throws RepositoryException
     */
    private function buildTable(SiteCapsuleInterface $capsule, array $parameters)
    {
        try
        {
            $table = new Table($capsule->getDatabaseConfiguration()->getTableName());

            $idColumn = $table->addColumn("id", "integer", [
                "unsigned"=>true
            ]);
            $idColumn->setAutoincrement(true);
            $table->setPrimaryKey(["id"]);

            foreach ($parameters as $key=>$parameter)
            {
                $type = $this->validateType(gettype($parameter));
                $table->addColumn($key, $type);
            }

            return $table;
        }
        catch (DBALException $e)
        {
            throw new RepositoryException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
        catch (\Exception $e)
        {
            throw new RepositoryException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * @param SiteCapsuleInterface $capsule
     * @return boolean
     */
    public function tableExists(SiteCapsuleInterface $capsule)
    {
        $tableName = $capsule->getDatabaseConfiguration()->getTableName();
        $connection = $this->getConnection();

        /** @var AbstractSchemaManager $schemaManager */
        $schemaManager = $connection->getSchemaManager();

        return $schemaManager->tablesExist([$tableName]);
    }

}