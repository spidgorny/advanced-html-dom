<?php

include dirname(__DIR__) . '/vendor/autoload.php';

$dom = new \Deimos\AdvancedHtmlDom\AdvancedHtmlDom();
$dom->cache(new \Deimos\AdvancedHtmlDom\CacheSystem\CacheStatic());

$dom->load_file('https://babichev.net/portfolio');
$dom->load_file('https://babichev.net/portfolio');
$dom->load_file('https://babichev.net/portfolio');
$dom->load_file('https://babichev.net/portfolio');
$dom->load_file('https://babichev.net/portfolio');

foreach ($dom->find('.lweel img') as $img)
{
    var_dump($img->attributes());
}
