<?php

namespace ApiHistogram\ApiHistogramBundle\Validators;

use ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException;


/**
 * Class Validate
 * @package ApiHistogram\ApiHistogramBundle\Validators
 */
class Validate
{
    /**
     * @param $target
     * @param array $validators
     * @param array $contexts
     * @throws ValidatorException
     * @return boolean
     */
    public function validate($target, array $validators, array $contexts)
    {
        foreach ($validators as $key=>$validator)
        {
            /** @var ValidatorInterface $validator */
            $validator->validate($target, $contexts[$key]);
        }

        return True;
    }

}