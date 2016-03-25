<?php

namespace ApiHistogram\ApiHistogramBundle\Tests\Cleaners;

use ApiHistogram\ApiHistogramBundle\Cleaners\CurrencyCleaner;
use GuzzleHttp\Message\Response;
use \PHPUnit_Framework_TestCase as TestCase;

/**
 * Class CurrencyCleanerTest
 * @package ApiHistogram\ApiHistogramBundle\Tests\Services\Loader\Cleaners
 */
class CurrencyCleanerTest extends TestCase
{
    /** @var CurrencyCleaner $cleaner */
    private $cleaner;

    public function setUp()
    {
        parent::setUp();

        $this->cleaner = new CurrencyCleaner();
    }


    /**
     * @param $responseData
     * @param $expected
     * @dataProvider responseContentProvider
     * @return array
     */
    public function testClean($responseData, $expected)
    {
        $responseMock = $this->prophesize(ConfigurationVariables::RESPONSE_NAMESPACE);

        //config
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
     * @dataProvider finalArrayProvider
     */
    public function testStructure($response, $expected)
    {
        $actual = $this->cleaner->structure($response);

        $this->assertNotNull($actual);
        $this->assertEquals($actual, $expected);

    }

    /**
     * @return array
     */
    public function responseContentProvider()
    {
        return [
            [
                [
                    'success' => true,
                    'terms' => 'https://currencylayer.com/terms',
                    'privacy' => 'https://currencylayer.com/privacy',
                    'timestamp' => 1458669610,
                    'source' => "USD",
                    'quotes' => [
                        'USDUSD' => 1,
                        'USDAUD' => 1.313025,
                        'USDCAD' => 1.30569,
                        'USDPLN' => 3.793198,
                        'USDMXN' => 17.320202
                    ]
                ],
                [
                    'timestamp' => 1458669610,
                    'quotes' => [
                        'USD' => 1,
                        'AUD' => 1.313025,
                        'CAD' => 1.30569,
                        'PLN' => 3.793198,
                        'MXN' => 17.320202
                    ]
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function finalArrayProvider()
    {
        return [
            [
                [
                    'timestamp' => 1458669610,
                    'quotes' => [
                        'USD' => 1,
                        'AUD' => 1.313025,
                        'CAD' => 1.30569,
                        'PLN' => 3.793198,
                        'MXN' => 17.320202
                    ]
                ],
                [
                    'timestamp'=>1458669610,
                    'USD' => 1,
                    'AUD' => 1.313025,
                    'CAD' => 1.30569,
                    'PLN' => 3.793198,
                    'MXN' => 17.320202
                ]
            ],
        ];
    }

}