<?php

namespace Bavix\AdvancedHtmlDom;

class Cleanup
{
    public static function all(): void
    {
        if (\function_exists('gc_collect_cycles')) {
            \gc_collect_cycles();
        }

        if (\function_exists('gc_mem_caches')) {
            \gc_mem_caches();
        }
    }
}

