<?php

include dirname(__DIR__) . '/vendor/autoload.php';

$dom = new \Deimos\AdvancedHtmlDom\AdvancedHtmlDom();

$dom->load_file('https://babichev.net/portfolio');

foreach ($dom->find('.lweel img') as $img)
        var_dump($img->attributes());
