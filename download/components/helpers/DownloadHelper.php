<?php

namespace download\components\helpers;

class DownloadHelper
{
    /**
     * Create a Cache Directory for Cache.
     * @param int $objectId
     * @return int
     */
    public static function cacheDirectory($objectId)
    {
        return $objectId % 100;
    }
}
