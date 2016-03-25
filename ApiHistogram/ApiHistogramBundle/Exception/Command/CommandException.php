<?php

namespace ApiHistogram\ApiHistogramBundle\Exception\Command;

use ApiHistogram\ApiHistogramBundle\Exception\ApiHistogramException;
use \Exception;

/**
 * Class CommandException
 * @package ApiHistogram\ApiHistogramBundle\Exception\Command
 */
class CommandException extends ApiHistogramException
{
    public function __construct($message, $code = 500, Exception $e)
    {
        parent::__construct($message, $code, $e);
    }
}