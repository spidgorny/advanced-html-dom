<?php

namespace Deimos\AdvancedHtmlDom\CacheSystem;

class WithoutCache implements InterfaceCache
{

    public function get($url)
    {
        return file_get_contents($url);
    }

}