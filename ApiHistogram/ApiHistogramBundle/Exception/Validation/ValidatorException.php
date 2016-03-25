<?php

namespace ApiHistogram\ApiHistogramBundle\Exception\Validation;

use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use \Exception;

/**
 * Class ValidatorException
 * @package ApiHistogram\ApiHistogramBundle\Exception\Validation
 */
class ValidatorException extends ApiHistogramException
{
    /**
     * ValidatorException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|NULL $previous
     */
    public function __construct($message, $code = 500, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}