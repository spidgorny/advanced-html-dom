<?php

namespace Deimos\AdvancedHtmlDom;

class AHTMLNode extends AdvancedHtmlBase implements \ArrayAccess
{
    private $_path;

    public function __construct($node, $doc)
    {
        $this->node    = $node;
        $this->_path   = $node->getNodePath();
        $this->doc     = $doc;
        $this->is_text = !!($node->nodeName === '#text');
    }

    private function get_fragment($html)
    {
        $dom = $this->doc->dom;
        $fragment = $dom->createDocumentFragment() or die('nope');
        $fragment->appendXML($html);

        return $fragment;
    }

    public function replace($html)
    {
        $node = empty($html) ? null : $this->before($html);
        $this->remove();

        return $node;
    }

    public function before($html)
    {
        $fragment = $this->get_fragment($html);
        $this->node->parentNode->insertBefore($fragment, $this->node);

        return new AHTMLNode($this->node->previousSibling, $this->doc);
    }

    public function after($html)
    {
        $fragment = $this->get_fragment($html);
        if ($ref_node = $this->node->nextSibling)
        {
            $this->node->parentNode->insertBefore($fragment, $ref_node);
        }
        else
        {
            $this->node->parentNode->appendChild($fragment);
        }
    }

    public function decamelize($str)
    {
        $str = preg_replace('/(^|[a-z])([A-Z])/e', 'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")', $str);

        return preg_replace('/ /', '_', strtolower($str));
    }

    public function attributes()
    {
        $ret = array();
        foreach ($this->node->attributes as $attr)
        {
            $ret[$attr->nodeName] = $attr->nodeValue;
        }

        return $ret;
    }

    public function flatten($key = null, $level = 1)
    {
        $children = $this->children;
        $ret      = array();
        $tag      = $this->tag;
        if ($this->at('./preceding-sibling::' . $this->tag) || $this->at('./following-sibling::' . $this->tag) || ($key = $this->tag . 's'))
        {
            $count = $this->search('./preceding-sibling::' . $this->tag)->length + 1;
            $tag .= '_' . $count;
        }
        if ($children->length == 0)
        {
            $ret[$this->decamelize(implode(' ', array_filter(array($key, $tag))))] = $this->text;
        }
        else
        {
            foreach ($children as $child)
            {
                $ret = array_merge($ret, $child->flatten(implode(' ', array_filter(array($key, $level <= 0 ? $tag : null))), $level - 1));
            }
        }

        return $ret;
    }

    public function __isset($name)
    {
        return true;
    }

    public function __set($key, $value)
    {
        switch ($key)
        {
            case 'text':
            case 'innertext':
            case 'innerText':
            case 'plaintext':
                $this->node->nodeValue = $value;

                return;
            case 'outertext':
                $this->replace($value);

                return;
            case 'tag':
                $el = $this->replace('<' . $value . '>' . $this->innerhtml . '</' . $value . '>');
                foreach ($this->node->attributes as $key => $att)
                {
                    $el->$key = $att->nodeValue;
                }
                $this->node = $el->node;

                return;

            //default: trigger_error('Unknown property: ' . $key, E_USER_WARNING);
            //case 'name': return $this->node->nodeName;
        }
        //trigger_error('Unknown property: ' . $key, E_USER_WARNING);
        if ($value === null)
        {
            $this->node->removeAttribute($key);
        }
        else
        {
            $this->node->setAttribute($key, $value);
        }

    }

    public function offsetExists($offset)
    {
        return true;
    }

    public function offsetGet($offset)
    {
        return $this->node->getAttribute($offset);
    }

    public function offsetSet($key, $value)
    {
        if ($value)
        {
            $this->node->setAttribute($key, $value);
        }
        else
        {
            $this->node->removeAttribute($key);
        }
        //trigger_error('offsetSet not implemented', E_USER_WARNING);
    }

    public function offsetUnset($offset)
    {
        trigger_error('offsetUnset not implemented', E_USER_WARNING);
    }

    public function title()
    {
        return $this->node->getAttribute('title');
    }
}
