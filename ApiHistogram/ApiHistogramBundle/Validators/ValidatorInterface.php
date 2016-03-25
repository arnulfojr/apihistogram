<?php

namespace ApiHistogram\ApiHistogramBundle\Validators;

use ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException;

/**
 * Interface ValidatorInterface
 * @package ApiHistogram\ApiHistogramBundle\Validators
 */
interface ValidatorInterface
{
    /**
     * @param $target
     * @param null $context
     * @return boolean
     * @throws ValidatorException
     */
    public function validate($target, $context = NULL);
}