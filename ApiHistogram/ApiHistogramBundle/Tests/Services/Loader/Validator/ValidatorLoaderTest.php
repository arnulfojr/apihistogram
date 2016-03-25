<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Validator;

use ApiHistogram\ApiHistogramBundle\Services\Loader\Validator\ValidatorLoader;
use ApiHistogram\ApiHistogramBundle\Validators\Loader\ImplementsInterfaceValidator;
use ApiHistogram\ApiHistogramBundle\Validators\Validate;
use \PHPUnit_Framework_TestCase as TestCase;
use ApiHistogram\ApiHistogramBundle\Tests\Validators\ConfigurationVariables as ValidatorsVariables;

/**
 * Class ValidatorLoaderTest
 * @package ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Validator
 */
class ValidatorLoaderTest extends TestCase
{

    /**
     * @param $validators
     * @param $expected
     * @dataProvider validatorProvider
     */
    public function testLoad($validators, $expected)
    {
        $validateMock = $this->prophesize(ValidatorsVariables::VALIDATE_NAMESPACE);

        // config

        /** @var Validate $validate */
        $validate = $validateMock->reveal();

        $validatorLoader = new ValidatorLoader($validate);

        $this->assertEquals($expected, $validatorLoader->instantiate($validators));
    }

    /**
     * @return array
     */
    public function validatorProvider()
    {
        return [
            [
                [
                    ValidatorsVariables::IMPLEMENTS_INTERFACE_VALIDATOR_CLASS
                ],
                [
                    new ImplementsInterfaceValidator()
                ]
            ],
        ];
    }

}