<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Validators;

use ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator;
use ApiHistogram\ApiHistogramBundle\Validators\Validate;
use ApiHistogram\ApiHistogramBundle\Validators\Validators;
use \PHPUnit_Framework_TestCase as TestCase;
use \ReflectionClass;


/**
 * Class ValidateTest
 * @package ApiHistogram\ApiHistogram\ApiHistogramBundle\Tests\Validators
 */
class ValidateTest extends TestCase
{
    /** @var Validate $validate */
    private $validate;

    public function setUp()
    {
        parent::setUp();

        $this->validate = new Validate();
    }

    /**
     * @param $target
     * @param $validators
     * @param $contexts
     * @dataProvider infoProvider
     */
    public function testValidate($target, $validators, $contexts)
    {
        $this->validate->validate($target, $validators, $contexts);
    }

    /**
     * @param $target
     * @param $validators
     * @param $contexts
     * @expectedException ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException
     * @dataProvider invalidDataProvider
     */
    public function testValidateInvalidData($target, $validators, $contexts)
    {
        $this->validate->validate($target, $validators, $contexts);
    }

    /**
     * @return array
     */
    public function infoProvider()
    {
        return [
            [
                new ReflectionClass(ConfigurationVariables::IMPLEMENTS_INTERFACE_VALIDATOR_CLASS), // target
                [], // validators
                [] // contexts
            ],
            [
                new ReflectionClass(ConfigurationVariables::IMPLEMENTS_INTERFACE_VALIDATOR_CLASS),
                [
                    new ImplementsInterfaceValidator()
                ],
                [
                    Validators::getContextSkeletonForImplementsInterface(Validators::VALIDATOR_INTERFACE)
                ]
            ],
            [
                new ImplementsInterfaceValidator(),
                [
                    new ImplementsInterfaceValidator()
                ],
                [
                    Validators::getContextSkeletonForImplementsInterface(Validators::VALIDATOR_INTERFACE)
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function invalidDataProvider()
    {
        return [
            [
                new ReflectionClass(ConfigurationVariables::IMPLEMENTS_INTERFACE_VALIDATOR_CLASS),
                [
                    new ImplementsInterfaceValidator()
                ],
                [
                    Validators::getContextSkeletonForImplementsInterface(ConfigurationVariables::INVALID_INTERFACE_NAMESPACE)
                ]
            ],
            [
                new ImplementsInterfaceValidator(),
                [
                    new ImplementsInterfaceValidator()
                ],
                [
                    Validators::getContextSkeletonForImplementsInterface(ConfigurationVariables::BUILDER_INTERFACE_NAMESPACE)
                ]
            ]
        ];
    }

}