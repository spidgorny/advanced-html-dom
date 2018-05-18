<?php

/**
 * @see https://github.com/monkeysuffrage/advanced_html_dom/issues/9
 */

include_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dom = \Bavix\AdvancedHtmlDom\strGetHtml('<body><p>x</p><p>y</p></body>');

echo $dom->find('p')[1];
