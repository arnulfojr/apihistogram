<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Services\Fetcher;

use ApiHistogram\ApiHistogramBundle\Container\Configuration\SiteCapsuleInterface;
use ApiHistogram\ApiHistogramBundle\Container\Configuration\URL\URL;
use ApiHistogram\ApiHistogramBundle\Services\Fetcher\Fetcher;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * Class FetcherTest
 * @package ApiHistogram\ApiHistogramBundle\Tests\Services\Fetcher
 */
class FetcherTest extends TestCase
{
    /** @var Fetcher $fetcher */
    private $fetcher;

    public function setUp()
    {
        parent::setUp();

        $this->fetcher = new Fetcher();
    }

    /**
     * @param string $urlString
     * @dataProvider urlProvider
     */
    public function testFetch($urlString)
    {
        $siteCapsuleMock = $this->prophesize(ConfigurationVariables::SITE_CAPSULE_SPACE_NAME);
        $URLMock = $this->prophesize(ConfigurationVariables::URL_SPACE_NAME);

        $URLMock
            ->getAsString()
            ->willReturn($urlString);

        /** @var URL $URL */
        $URL = $URLMock->reveal();

        $siteCapsuleMock
            ->getURL()
            ->willReturn($URL);

        /** @var SiteCapsuleInterface $siteCapsule */
        $siteCapsule = $siteCapsuleMock->reveal();

        $this->assertNotNull($this->fetcher->fetch($siteCapsule));
    }


    /**
     * @return array
     */
    public function urlProvider()
    {
        return [
            [
                'http://www.moreandcoffee.com/dataManager?data=places'
            ]
        ];
    }

}