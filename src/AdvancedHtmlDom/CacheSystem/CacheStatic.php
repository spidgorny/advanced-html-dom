<?php

namespace Deimos\AdvancedHtmlDom\CacheSystem;

class CacheStatic implements InterfaceCache
{

    protected static $cache = [];

    public function get($url)
    {
        if (!isset(self::$cache[$url]))
        {
            self::$cache[$url] = file_get_contents($url);
        }

        return self::$cache[$url];
    }

}