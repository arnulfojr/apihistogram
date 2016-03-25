<?php

namespace ApiHistogram\ApiHistogramBundle\Exception;

use \Exception;

/**
 * Class InvalidArgumentException
 * @package ApiHistogram\ApiHistogramBundle\Exception
 */
class InvalidArgumentException extends ApiHistogramException
{
    /** @var string $actualClassName */
    protected $actualClassName = "";
    /** @var string $expectedClassName */
    protected $expectedClassName = "";

    /**
     * InvalidArgumentException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|NULL $previous
     */
    public function __construct($message, $code, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getActualClassName()
    {
        return $this->actualClassName;
    }

    /**
     * @param string $actualClassName
     * @return InvalidArgumentException
     */
    public function setActualClassName($actualClassName)
    {
        $this->actualClassName = $actualClassName;

        return $this;
    }

    /**
     * @param string $expectedClassName
     * @return InvalidArgumentException
     */
    public function setExpectedClassName($expectedClassName)
    {
        $this->expectedClassName = $expectedClassName;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpectedClassName()
    {
        return $this->expectedClassName;
    }

}