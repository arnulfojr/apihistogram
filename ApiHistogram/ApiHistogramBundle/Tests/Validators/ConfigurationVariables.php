<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Validators;

/**
 * Class ConfigurationVariables
 * @package ApiHistogram\ApiHistogramBundle\Tests\Validators
 */
class ConfigurationVariables
{
    const IMPLEMENTS_INTERFACE_VALIDATOR_CLASS = 'ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator';

    const BUILDER_INTERFACE_NAMESPACE = 'ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder\BuilderInterface';

    const INVALID_INTERFACE_NAMESPACE = 'ApiHistogram\ApiHistogramBundle\Validators\Loader\SomeInterface';

    const VALIDATE_NAMESPACE = 'ApiHistogram\ApiHistogramBundle\Validators\Validate';
}