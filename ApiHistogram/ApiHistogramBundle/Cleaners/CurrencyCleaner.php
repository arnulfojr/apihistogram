<?php

namespace ApiHistogram\ApiHistogramBundle\Cleaners;

use ApiHistogram\ApiHistogramBundle\Cleaners\Helper\CleanerHelper;
use ApiHistogram\ApiHistogramBundle\Exception\Cleaners\CleanerException;
use ApiHistogram\ApiHistogramBundle\Exception\ExceptionParameters;
use GuzzleHttp\Message\Response;

/**
 * Class CurrencyCleaner
 * @package ApiHistogram\ApiHistogramBundle\Cleaners
 */
class CurrencyCleaner extends CleanerHelper implements CleanerInterface
{

    const QUOTES = 'quotes';

    /**
     * @param $response
     * @return mixed
     */
    public function clean(Response $response)
    {
        $content = $response->json();
        $cleaned = $this->removeAttributes($content, $this->getRemovableAttributes());

        $cleaned[CurrencyCleaner::QUOTES] = $this->renameKeys(
            $cleaned[CurrencyCleaner::QUOTES],
            $this->getNewKeys()
        );

        return $cleaned;
    }

    /**
     * @param $unstructured
     * @return mixed
     * @throws CleanerException
     */
    public function structure($unstructured)
    {
        //only put quotes one level up
        if (array_key_exists(CurrencyCleaner::QUOTES, $unstructured))
        {
            foreach ($unstructured[CurrencyCleaner::QUOTES] as $name=>$value)
            {
                $unstructured[$name] = $value;
                unset($unstructured[CurrencyCleaner::QUOTES][$name]);
            }

            unset($unstructured[CurrencyCleaner::QUOTES]);

            return $unstructured;
        }

        throw new CleanerException(
            ExceptionParameters::CLEANER_EXCEPTION_MESSAGE,
            ExceptionParameters::CLEANER_EXCEPTION_STRUCTURE_CODE
        );
    }

    /**
     * @return array
     */
    static public function getNewKeys()
    {
        return [
            "USDUSD"=>"USD",
            "USDAUD"=>"AUD",
            "USDCAD"=>"CAD",
            "USDPLN"=>"PLN",
            "USDMXN"=>"MXN"
        ];
    }

    /**
     * @return array
     */
    static public function getRemovableAttributes()
    {
        return [
            'success',
            'terms',
            'privacy',
            'source'
        ];
    }

}