<?php

include dirname(__DIR__) . '/vendor/autoload.php';

// test 1
$mt = microtime(true);

$dom = new \Bavix\AdvancedHtmlDom\AdvancedHtmlDom();
$dom->setCache(new \Bavix\AdvancedHtmlDom\CacheSystem\CacheStatic());

$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');

$mt1 = microtime(true) - $mt;

// test 2
$mt = microtime(true);

$dom = new \Bavix\AdvancedHtmlDom\AdvancedHtmlDom();

$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');
$dom->loadFile('https://babichev.net/portfolio');

$mt2 = microtime(true) - $mt;

var_dump('about a caching quicker -- ' . ($mt1 < $mt2 ? 'yes' : 'no'), $mt1, $mt2);

foreach ($dom->find('.lweel img') as $img)
{
    var_dump($img->attributes());
}
