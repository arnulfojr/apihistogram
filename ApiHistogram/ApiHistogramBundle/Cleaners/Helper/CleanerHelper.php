<?php

namespace ApiHistogram\ApiHistogramBundle\Cleaners\Helper;

/**
 * Class CleanerHelper
 * @package ApiHistogram\ApiHistogramBundle\Cleaners\Helper
 */
class CleanerHelper
{
    /**
     * @param array $dirty
     * @param array $removable
     * @return array
     */
    protected function removeAttributes(array $dirty, array $removable)
    {
        $cleaned = $dirty;

        foreach ($removable as $attr)
        {
            if (array_key_exists($attr, $cleaned))
            {
                unset($cleaned[$attr]);
            }
        }

        return $cleaned;
    }

    /**
     * @param array $dirty
     * @param array $keys
     * @return array
     */
    public function renameKeys(array $dirty, array $keys)
    {
        foreach ($keys as $old=>$new)
        {
            $dirty[$new] = $dirty[$old];
            unset($dirty[$old]);
        }

        return $dirty;
    }

}