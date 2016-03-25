<?php

namespace ApiHistogram\ApiHistogramBundle\Validators\Loader\Cleaner;

use ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException;
use ApiHistogram\ApiHistogramBundle\Validators\ValidatorInterface;

/**
 * Class ValidStringValidator
 * @package ApiHistogram\ApiHistogramBundle\Validators\Loader\Cleaner
 */
class ValidStringValidator implements ValidatorInterface
{

    /**
     * @param $target
     * @param null $context
     * @return boolean
     * @throws ValidatorException
     */
    public function validate($target, $context = NULL)
    {
        // TODO: Implement validate() method.
    }
}