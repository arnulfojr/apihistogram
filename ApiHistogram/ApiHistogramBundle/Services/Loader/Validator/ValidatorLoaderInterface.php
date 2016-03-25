<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Validator;

/**
 * Interface ValidatorLoaderInterface
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader
 */
interface ValidatorLoaderInterface
{
    /**
     * @param array $validators
     * @return ValidatorLoaderInterface
     */
    public function setValidators(array $validators);

}