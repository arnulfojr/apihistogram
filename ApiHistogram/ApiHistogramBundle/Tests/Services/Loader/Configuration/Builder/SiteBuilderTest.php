<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Configuration\Builder;

use ApiHistogram\ApiHistogramBundle\Services\Loader\Configuration\Builder\SiteBuilder;
use ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Configuration\ConfigurationVariables;
use \PHPUnit_Framework_TestCase;

class SiteBuilderTest extends PHPUnit_Framework_TestCase
{
    /** @var SiteBuilder $builder */
    private $builder;

    /** @var array $config */
    private $config;

    public function setUp()
    {
        parent::setUp();

        $this->builder = new SiteBuilder();

        $this->config = ConfigurationVariables::getConfig();
    }

    /**
     * @param $expectedResult
     * @param $siteOptions
     * @dataProvider siteOptionsProvider
     */
    public function testBuild($expectedResult, $siteOptions)
    {
        $this->assertEquals($expectedResult, $this->builder->build($siteOptions));
    }

    /**
     * @return array
     */
    public function siteOptionsProvider()
    {
        $toReturn = [];

        $sites = ConfigurationVariables::getSiteCapsules();
        $siteOptions = ConfigurationVariables::getSitesConfig();

        foreach($sites as $name=>$site)
        {
            $helper = [
                $site,
                $name=>$siteOptions[$name]
            ];

            $toReturn[] = $helper;
        }

        return $toReturn;
    }

}