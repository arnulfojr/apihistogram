<?php

namespace ApiHistogram\ApiHistogramBundle\Services\Loader\Validator;

use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Exception\Loader\LoaderException;
use ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException;
use ApiHistogram\ApiHistogramBundle\Services\Loader\ClassLoader;
use ApiHistogram\ApiHistogramBundle\Services\Loader\InstantiateInterface;
use ApiHistogram\ApiHistogramBundle\Validators\Validate;
use ApiHistogram\ApiHistogramBundle\Validators\Validators;

/**
 * Class ValidatorLoader
 * @package ApiHistogram\ApiHistogramBundle\Services\Loader
 */
class ValidatorLoader extends ClassLoader implements InstantiateInterface
{
    /** @var null|array $validators */
    private $validators = NULL;

    /** @var Validate $validate */
    private $validate;

    /**
     * ValidatorLoader constructor.
     * @param Validate $validate
     */
    public function __construct(Validate $validate)
    {
        $this->validate = $validate;
    }

    /**
     * @param array $validators
     * @return ValidatorLoaderInterface
     */
    public function setValidators(array $validators)
    {
        $this->validators = $validators;
    }

    /**
     * @param array|NULL $validators
     * @return array
     * @throws LoaderException
     */
    public function instantiate(array $validators = NULL)
    {
        $validators = $this->decideValidators($validators);
        $toReturn = [];

        $validatorsToUse = Validators::forValidatorLoader();

        $contexts = $this->getContexts();

        try
        {
            foreach($validators as $validatorNamespace)
            {
                /** @var \ReflectionClass $instantiatedClass */
                $instantiatedClass = $this->load($validatorNamespace);

                $this->validate->validate($instantiatedClass, $validatorsToUse, $contexts);

                $toReturn[] = $instantiatedClass;
            }
        }
        catch (ValidatorException $e)
        {
            throw new LoaderException(
                ExceptionParameters::getLoaderFailedMessage("it does not implement the Validator Interface"),
                ExceptionParameters::LOADER_FAILED_CODE,
                $e
            );
        }

        return $toReturn;
    }

    /**
     * @return array
     */
    protected function getContexts()
    {
        $contexts = [];

        $contexts[] = Validators::getContextSkeletonForImplementsInterface(Validators::VALIDATOR_INTERFACE);

        return $contexts;
    }

    /**
     * @param array|NULL $validators
     * @return array|null
     */
    protected function decideValidators(array $validators = NULL)
    {
        if ($validators === NULL)
        {
            return $this->validators;
        }

        return $validators;

    }

}