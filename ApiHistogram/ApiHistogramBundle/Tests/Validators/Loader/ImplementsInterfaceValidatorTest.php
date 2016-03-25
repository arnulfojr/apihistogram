<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Validators\Loader;

use ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator;
use \ReflectionClass;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * Class ImplementsInterfaceValidatorTest
 * @package ApiHistogram\ApiHistogramBundle\Tests\Validators\Loader
 */
class ImplementsInterfaceValidatorTest extends TestCase
{
    /** @var ImplementsInterfaceValidator $validator */
    private $validator;

    public function setUp()
    {
        parent::setUp();

        $this->validator = new ImplementsInterfaceValidator();
    }

    /**
     * @param $class
     * @param $interface
     * @expectedException ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException
     * @dataProvider invalidClassesProvider
     */
    public function testValidateFalse($class, $interface)
    {
        $context = ConfigurationVariables::getImplementsInterfaceContextSkeleton($interface);

        $this->validator->setContext($context);

        $this->assertNull($this->validator->validate($class));
    }

    /**
     * @param $class
     * @param $interface
     * @dataProvider validClassesProvider
     */
    public function testValidateTrue($class, $interface)
    {
        $context = ConfigurationVariables::getImplementsInterfaceContextSkeleton($interface);

        $this->validator->setContext($context);

        $this->assertTrue($this->validator->validate($class, $context));
    }

    /**
     * @return array
     */
    public function validClassesProvider()
    {
        return [
            [
                new ReflectionClass(ConfigurationVariables::IMPLEMENTS_INTERFACE_VALIDATOR_CLASS),
                'ApiHistogram\ApiHistogramBundle\Validators\ValidatorInterface'
            ],
            [
                new ReflectionClass(ConfigurationVariables::CONFIGURATION_CLASS),
                ConfigurationVariables::CONFIGURATION_INTERFACE
            ],
            [
                new ImplementsInterfaceValidator(),
                'ApiHistogram\ApiHistogramBundle\Validators\ValidatorInterface'
            ]
        ];
    }

    /**
     * @return array
     */
    public function invalidClassesProvider()
    {
        return [
            [
                new ReflectionClass(ConfigurationVariables::IMPLEMENTS_INTERFACE_VALIDATOR_CLASS),
                'ApiHistogram\ApiHistogramBundle\Services\Loader\Cleaner\CleanerLoaderInterface'
            ],
            [
                new ReflectionClass(ConfigurationVariables::CONFIGURATION_CLASS),
                'ApiHistogram\ApiHistogramBundle\Services\Loader\Cleaner\CleanerLoaderInterface'
            ],
            [
                new ImplementsInterfaceValidator(),
                'ApiHistogram\ApiHistogramBundle\Service\Loader\Cleaner\CleanerLoaderInterface'
            ]
        ];
    }

}