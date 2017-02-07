<?php

namespace Deimos\AdvancedHtmlDom;

$attributes = array('href', 'src', 'id', 'class', 'name', 'text', 'height', 'width', 'content', 'value', 'title', 'alt');

$tags = array('a', 'abbr', 'address', 'area', 'article', 'aside', 'audio', 'b', 'base', 'blockquote', 'body', 'br', 'button', 'canvas', 'caption', 'cite', 'code', 'col', 'colgroup', 'data', 'datalist', 'dd', 'detail', 'dialog', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form', 'font', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header', 'hgroup', 'hr', 'html', 'i', 'iframe', 'img', 'image', 'input', 'label', 'legend', 'li', 'map', 'mark', 'menu', 'meta', 'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'p', 'param', 'pre', 'script', 'section', 'select', 'small', 'source', 'span', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title', 'tr', 'track', 'u', 'ul', 'var', 'video');

$tags       = implode('|', $tags);
$attributes = implode('|', $attributes);

define('TAG_REGEX', '/^(' . $tags . ')$/');
define('TAGS_REGEX', '/^(' . $tags . ')e?s$/');

define('ATTRIBUTE_REGEX', '/^(' . $attributes . '|data-\w+)$/');
define('ATTRIBUTES_REGEX', '/^(' . $attributes . '|data-\w+)e?s$/');

function str_get_html($html)
{
    return new AdvancedHtmlDom($html);
}

function file_get_html($url)
{
    return str_get_html(file_get_contents($url));
}

function str_get_xml($html)
{
    return new AdvancedHtmlDom($html, true);
}

function file_get_xml($url)
{
    return str_get_xml(file_get_contents($url));
}
