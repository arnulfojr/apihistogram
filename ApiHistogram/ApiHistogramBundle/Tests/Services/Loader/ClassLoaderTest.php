<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Services\Loader;

use ApiHistogram\ApiHistogramBundle\Cleaners\CleanerInterface;
use ApiHistogram\ApiHistogramBundle\Services\Loader\ClassLoader;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * Class ClassLoaderTest
 * @package ApiHistogram\ApiHistogramBundle\Tests\Services\Loader
 */
class ClassLoaderTest extends TestCase
{
    /** @var ClassLoader $classLoader */
    private $classLoader;

    public function setUp()
    {
        parent::setUp();
        $this->classLoader = new ClassLoader();
    }

    /**
     * @param $classNamespace
     * @dataProvider classNamespaceCleanersImplementationProvider
     */
    public function testLoadCleanerImplementationTrue($classNamespace)
    {
        /** @var CleanerInterface $cleaner */
        $cleaner = $this->classLoader->load($classNamespace);

        $implementations = class_implements($cleaner);

        $this->assertArrayHasKey(ConfigurationVariables::CLEANER_INTERFACE_CLASS, $implementations);
    }

    /**
     * @param $classNamespace
     * @dataProvider classNamespaceProvider
     */
    public function testLoadCleanerNoImplementation($classNamespace)
    {
        /** @var \ReflectionClass $cleaner */
        $cleaner = $this->classLoader->load($classNamespace);

        $implementations = class_implements($cleaner);

        $this->assertArrayNotHasKey(ConfigurationVariables::CLEANER_INTERFACE_CLASS, $implementations);
    }

    /**
     * @param $classNamespace
     * @dataProvider nonExistentClassNamespaceProvider
     * @expectedException ApiHistogram\ApiHistogramBundle\Exception\Loader\LoaderException
     */
    public function testNonExistentClassNamespace($classNamespace)
    {
        $class = $this->classLoader->load($classNamespace);

        $this->assertNotNull($class, "Class in NULL");
    }

    /**
     * @return array
     */
    public function nonExistentClassNamespaceProvider()
    {
        return [
            [
                'ApiHistogram\ApiHistogramBundle\Cleaners\CurrencyCleaners'
            ],
        ];
    }

    /**
     * @return array
     */
    public function classNamespaceCleanersImplementationProvider()
    {
        return [
            [
                'ApiHistogram\ApiHistogramBundle\Cleaners\CurrencyCleaner'
            ],
        ];
    }

    /**
     * @return array
     */
    public function classNamespaceProvider()
    {
        return [
            [
                'ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsule'
            ],
        ];
    }

}