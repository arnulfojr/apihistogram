<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Cleaners;

use ApiHistogram\ApiHistogramBundle\Cleaners\YahooStockCleaner;
use GuzzleHttp\Message\Response;
use \PHPUnit_Framework_TestCase as TestCase;

class YahooStockCleanerTest extends TestCase
{
    /** @var YahooStockCleaner $cleaner */
    private $cleaner;

    public function setUp()
    {
        parent::setUp();
        $this->cleaner = new YahooStockCleaner();
    }

    /**
     * @param $responseData
     * @param $expected
     * @dataProvider responseContentProvider
     */
    public function testClean($responseData, $expected)
    {
        $responseMock = $this->prophesize(ConfigurationVariables::RESPONSE_NAMESPACE);

        // config
        $responseMock
            ->json()
            ->willReturn($responseData);

        /** @var Response $response */
        $response = $responseMock->reveal();

        $cleaned = $this->cleaner->clean($response);

        $this->assertNotNull($cleaned);
        $this->assertEquals($expected, $cleaned);
    }

    /**
     * @param $response
     * @param $expected
     * @dataProvider cleanedContentProvider
     */
    public function testStructure($response, $expected)
    {
        $actual = $this->cleaner->structure($response);

        $this->assertNotNull($actual);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function responseContentProvider()
    {
        return [
            [
                [
                    "list"=>[
                        "meta"=>[
                            "count"=>1,
                            "start"=>0,
                            "type"=>"resource-list"
                        ],
                        "resources"=>[
                            [
                                "resource"=>[
                                    "classname"=>"Qoute",
                                    "fields"=>[
                                        "name"=>"Apple Inc.",
                                        "price"=>"106.129997",
                                        "symbol"=>"AAPL",
                                        "ts"=>"1458763200",
                                        "type"=>"equity",
                                        "utctime"=>"2016-03-23T20:00:00+0000",
                                        "volume"=>"25603165"
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "resource"=>[
                        "classname"=>"Qoute",
                        "fields"=>[
                            "name"=>"Apple Inc.",
                            "price"=>"106.129997",
                            "symbol"=>"AAPL",
                            "ts"=>"1458763200",
                            "type"=>"equity",
                            "utctime"=>"2016-03-23T20:00:00+0000",
                            "volume"=>"25603165"
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function cleanedContentProvider()
    {
        return [
            [
                [
                    "resource"=>[
                        "classname"=>"Qoute",
                        "fields"=>[
                            "name"=>"Apple Inc.",
                            "price"=>"106.129997",
                            "symbol"=>"AAPL",
                            "ts"=>"1458763200",
                            "type"=>"equity",
                            "utctime"=>"2016-03-23T20:00:00+0000",
                            "volume"=>"25603165"
                        ]
                    ]
                ],
                [
                    "price"=>floatval("106.129997"),
                    "timestamp"=>floatval("1458763200"),
                    "volume"=>floatval("25603165")
                ]
            ]
        ];
    }

}