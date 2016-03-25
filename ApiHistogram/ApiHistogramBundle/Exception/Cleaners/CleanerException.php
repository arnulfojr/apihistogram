<?php

namespace ApiHistogram\ApiHistogramBundle\Exception\Cleaners;

use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use \Exception;

/**
 * Class CleanerException
 * @package ApiHistogramBundle\Exception\Cleaners
 */
class CleanerException extends ApiHistogramException
{
    public function __construct($message, $code, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}