<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Validators\Loader;

use ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator;

/**
 * Class ConfigurationVariables
 * @package ApiHistogram\ApiHistogramBundle\Tests\Validator\Loader
 */
class ConfigurationVariables
{

    const CONFIGURATION_CLASS = 'ApiHistogram\ApiHistogramBundle\Container\Configuration\Configuration';

    const CONFIGURATION_INTERFACE = 'ApiHistogram\ApiHistogramBundle\Container\Configuration\ConfigurationInterface';

    const IMPLEMENTS_INTERFACE_VALIDATOR_CLASS = 'ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator';

    /**
     * @param string|NULL $interfaceName
     * @return array
     */
    static public function getImplementsInterfaceContextSkeleton($interfaceName = NULL)
    {
        $skeleton = [
            ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY=>""
        ];

        if (!is_null($interfaceName))
        {
            $skeleton[ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY] = $interfaceName;
        }

        return $skeleton;
    }

}