<?php

namespace ApiHistogram\ApiHistogramBundle\Validators\Loader;

use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use ApiHistogram\ApiHistogramBundle\Exception\Validation\ValidatorException;
use ApiHistogram\ApiHistogramBundle\Validators\ValidatorInterface;
use \ReflectionClass;
use \ReflectionException;

/**
 * Class ImplementsInterfaceValidator
 * @package ApiHistogram\ApiHistogramBundle\Validators\Loader\Cleaner
 */
class ImplementsInterfaceValidator implements ValidatorInterface
{

    /** @var array $context */
    private $context;

    const CONTEXT_INTERFACE_KEY = "interface";

    const EXCEPTION_MESSAGE = "The validation failed while checking if the target implements the given Interface";

    /**
     * @param $target
     * @param null $context
     * @return boolean
     * @throws ValidatorException
     */
    public function validate($target, $context = NULL)
    {
        $this->validateContext($context);
        $context = $this->getContext($context);

        try
        {
            if ($target instanceof ReflectionClass)
            {
                if ($target->implementsInterface($context[ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY]))
                {
                    // ok
                    return True;
                }
            }

            if ($target instanceof $context[ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY])
            {
                return True;
            }
        }
        catch (ReflectionException $e)
        {
            throw new ValidatorException(
                ExceptionParameters::getLoaderFailedMessage(ExceptionParameters::INTERFACE_NOT_FOUND_MESSAGE),
                ExceptionParameters::LOADER_FAILED_CODE,
                $e
            );
        }

        $description = ImplementsInterfaceValidator::EXCEPTION_MESSAGE;
        $key = ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY;
        throw new ValidatorException(
            ExceptionParameters::getValidationFailed("{$description}: {$context[$key]}"),
            ExceptionParameters::VALIDATOR_FAILED_CODE,
            NULL
        );
    }

    /**
     * @param null $context
     * @return array|null
     */
    protected function getContext($context = NULL)
    {
        if (is_null($context))
        {
            return $this->context;
        }

        return $context;
    }

    /**
     * @param array $context
     * @return ImplementsInterfaceValidator
     */
    public function setContext(array $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @param $context
     * @return bool
     * @throws ValidatorException
     */
    protected function validateContext($context)
    {
        if (is_array($context))
        {
            if (array_key_exists(ImplementsInterfaceValidator::CONTEXT_INTERFACE_KEY, $context))
            {
                return True;
            }
        }

        throw new ValidatorException(
            ExceptionParameters::getContextFailed(get_class($context)),
            ExceptionParameters::VALIDATOR_CONTEXT_FAILED_CODE,
            NULL
        );
    }
}