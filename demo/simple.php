<?php

include dirname(__DIR__) . '/vendor/autoload.php';

$dom = new \Bavix\AdvancedHtmlDom\AdvancedHtmlDom();

$dom->loadFile('https://babichev.net/portfolio');

foreach ($dom->find('.lweel img') as $img)
{
    var_dump($img->attributes());
}
