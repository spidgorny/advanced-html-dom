<?php

/**
 * @see https://github.com/monkeysuffrage/advanced_html_dom/issues/10
 */

include_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$dom = \Bavix\AdvancedHtmlDom\strGetHtml('<html><table><tr><td>1
<td>2<tr><td>3<td></body></html>');

var_dump($dom->find('tr',0)->clean_text);