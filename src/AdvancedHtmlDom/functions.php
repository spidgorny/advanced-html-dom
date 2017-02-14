<?php

namespace Deimos\AdvancedHtmlDom;

use Deimos\AdvancedHtmlDom\CacheSystem\InterfaceCache;

$attributes = array(
    'href', 'src', 'id', 'class', 'name',
    'text', 'height', 'width', 'content',
    'value', 'title', 'alt'
);

$tags = array(
    'a', 'abbr', 'address', 'area', 'article', 'aside',
    'audio', 'b', 'base', 'blockquote', 'body', 'br',
    'button', 'canvas', 'caption', 'cite', 'code', 'col',
    'colgroup', 'data', 'datalist', 'dd',
    'detail', 'dialog', 'div', 'dl', 'dt', 'em',
    'embed', 'fieldset', 'figcaption', 'figure', 'footer', 'form',
    'font', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
    'head', 'header', 'hgroup', 'hr', 'html', 'i', 'iframe', 'img', 'image',
    'input', 'label', 'legend', 'li', 'map', 'mark', 'menu', 'meta',
    'nav', 'noscript', 'object', 'ol', 'optgroup', 'option', 'p',
    'param', 'pre', 'script', 'section', 'select', 'small', 'source', 'span',
    'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td',
    'textarea', 'tfoot', 'th', 'thead', 'title', 'tr',
    'track', 'u', 'ul', 'var', 'video'
);

$tags       = implode('|', $tags);
$attributes = implode('|', $attributes);

/**
 * TAG_REGEX
 */
define('TAG_REGEX', '/^(' . $tags . ')$/');

/**
 * TAGS_REGEX
 */
define('TAGS_REGEX', '/^(' . $tags . ')e?s$/');

/**
 * ATTRIBUTE_REGEX
 */
define('ATTRIBUTE_REGEX', '/^(' . $attributes . '|data-\w+)$/');

/**
 * ATTRIBUTES_REGEX
 */
define('ATTRIBUTES_REGEX', '/^(' . $attributes . '|data-\w+)e?s$/');

/**
 * @param string         $html
 * @param InterfaceCache $cache
 *
 * @return AdvancedHtmlDom
 */
function str_get_html($html, InterfaceCache $cache = null)
{
    $adv = new AdvancedHtmlDom($html);

    if ($cache)
    {
        $adv->setCache($cache);
    }

    return $adv;
}

/**
 * @param string         $url
 * @param InterfaceCache $cache
 *
 * @return AdvancedHtmlDom
 */
function file_get_html($url, InterfaceCache $cache = null)
{
    if ($cache)
    {
        return str_get_html($cache->get($url));
    }

    return str_get_html(file_get_contents($url));
}

/**
 * @param string         $html
 * @param InterfaceCache $cache
 *
 * @return AdvancedHtmlDom
 */
function str_get_xml($html, InterfaceCache $cache = null)
{
    $adv = new AdvancedHtmlDom($html, true);

    if ($cache)
    {
        $adv->setCache($cache);
    }

    return $adv;
}

/**
 * @param string         $url
 * @param InterfaceCache $cache
 *
 * @return AdvancedHtmlDom
 */
function file_get_xml($url, InterfaceCache $cache = null)
{
    if ($cache)
    {
        return str_get_xml($cache->get($url));
    }

    return str_get_xml(file_get_contents($url));
}
