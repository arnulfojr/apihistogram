<?php

namespace ApiHistogram\ApiHistogramBundle\Validators;

use ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator;


/**
 * Class Validators
 * @package ApiHistogram\ApiHistogramBundle\Validators
 */
class Validators
{

    const VALIDATOR_INTERFACE = 'ApiHistogram\ApiHistogramBundle\Validators\ValidatorInterface';

    /**
     * @param string $interfaceName
     * @return array
     */
    static public function getContextSkeletonForImplementsInterface($interfaceName = '')
    {
        return [
            ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY=>$interfaceName
        ];
    }

    /**
     * @return array
     */
    static public function forCleaners()
    {
        return [
            'ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator',
        ];
    }

    /**
     * @return array
     */
    static public function forValidatorLoader()
    {
        return [
            new ImplementsInterfaceValidator()
        ];
    }

}