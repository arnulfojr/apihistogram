<?php

namespace ApiHistogram\ApiHistogramBundle\Repository\Dynamic;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Exception\Repository\DoctrineException;
use ApiHistogram\ApiHistogramBundle\Exception\Repository\RepositoryException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use \InvalidArgumentException;

/**
 * Class DynamicEntityManager
 * @package ApiHistogram\ApiHistogramBundle\Repository\Dynamic
 */
class DynamicEntityManager
{
    /** @var EntityManagerInterface $_em */
    private $_em = NULL;
    /** @var Registry $doctrine */
    protected $doctrine;

    /**
     * DynamicEntityManager constructor.
     * @param Registry $doctrine
     */
    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param EntityManagerInterface $em
     * @return DynamicEntityManager $this
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->_em = $em;
        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->_em;
    }

    /**
     * @return Connection
     * @throws RepositoryException
     */
    public function getConnection()
    {
        if (is_null($this->_em))
        {
            throw new RepositoryException(
                ExceptionParameters::getEntityManagerNotSetMessage("The Entity Manager is not set."),
                ExceptionParameters::ENTITY_MANAGER_NOT_SET_CODE,
                NULL
            );
        }
        $con = $this->_em->getConnection();
        $this->pingConnection($con);
        return $con;
    }

    /**
     * @param Connection $connection
     * @return Connection
     */
    protected function pingConnection(Connection $connection)
    {
        if ($connection->ping() === false)
        {
            $connection->close();
            $connection->connect();
        }
        return $connection;
    }

    /**
     * @param string $connectionName
     * @throws DoctrineException
     */
    public function setUp($connectionName = 'default')
    {
        try
        {
            $this->_em = $this->doctrine->getManager($connectionName);
        }
        catch (InvalidArgumentException $e)
        {
            throw new DoctrineException(
                ExceptionParameters::DOCTRINE_ENTITY_MANAGER_INVALID_MESSAGE,
                ExceptionParameters::DOCTRINE_ENTITY_MANAGER_INVALID_CODE,
                $e
            );
        }
    }

    /**
     * @param SiteCapsuleInterface $capsule
     * @param ConfigurationInterface $configuration
     * @return string
     */
    protected function getTableExpression(SiteCapsuleInterface $capsule, ConfigurationInterface $configuration)
    {
        return "{$configuration->getSchemaName()}.{$capsule->getDatabaseConfiguration()->getTableName()}";
    }

    /**
     *
     * Validates the data type, if it is not a valid type then returns the valid type
     *
     * @param string $type
     * @return string
     */
    protected function validateType($type)
    {
        // TODO: fill all other fields
        switch ($type)
        {
            case "double":
                return "float";
            break;
            default:
                return $type;
        }
    }

}