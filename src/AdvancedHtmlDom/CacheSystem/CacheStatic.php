<?php

namespace Bavix\AdvancedHtmlDom\CacheSystem;

class CacheStatic implements InterfaceCache
{

    /**
     * @var array
     */
    protected static $cache = [];

    /**
     * @param $url
     *
     * @return mixed
     */
    public function get($url)
    {
        if (!isset(self::$cache[$url]))
        {
            self::$cache[$url] = \file_get_contents($url);
        }

        return self::$cache[$url];
    }

}
