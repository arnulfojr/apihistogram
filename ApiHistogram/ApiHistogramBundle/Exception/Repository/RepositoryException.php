<?php

namespace ApiHistogram\ApiHistogramBundle\Exception\Repository;

use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use \Exception;

/**
 * Class RepositoryException
 * @package ApiHistogram\ApiHistogramBundle\Exception\Repository
 */
class RepositoryException extends ApiHistogramException
{
    /**
     * RepositoryException constructor.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message, $code, Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}