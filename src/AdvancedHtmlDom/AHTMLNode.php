<?php

namespace Bavix\AdvancedHtmlDom;

/**
 * Class AHTMLNode
 *
 * @package Bavix\AdvancedHtmlDom
 *
 * @property-read string $clean_text
 */
class AHTMLNode extends AdvancedHtmlBase implements \ArrayAccess
{

    /**
     * @var
     */
    private $_path;

    /**
     * AHTMLNode constructor.
     *
     * @param $node
     * @param $doc
     */
    public function __construct($node, $doc)
    {
        $this->node    = $node;
        $this->_path   = $node->getNodePath();
        $this->doc     = $doc;
        $this->is_text = $node->nodeName === '#text';
    }

    /**
     * @inheritdoc
     */
    public function __destruct()
    {
        $this->_path = null;
        unset($this->_path);
        parent::__destruct();
    }

    /**
     * @param $html
     *
     * @return mixed
     */
    private function get_fragment($html)
    {
        $dom = $this->doc->dom;
        $fragment = $dom->createDocumentFragment() or die('nope');
        $fragment->appendXML($html);

        return $fragment;
    }

    /**
     * @param $html
     *
     * @return AHTMLNode|null
     */
    public function replace($html)
    {
        $node = empty($html) ? null : $this->before($html);
        $this->remove();

        return $node;
    }

    /**
     * @param $html
     *
     * @return AHTMLNode
     */
    public function before($html)
    {
        $fragment = $this->get_fragment($html);
        $this->node->parentNode->insertBefore($fragment, $this->node);

        return new AHTMLNode($this->node->previousSibling, $this->doc);
    }

    /**
     * @param $html
     */
    public function after($html)
    {
        $fragment = $this->get_fragment($html);
        if ($ref_node = $this->node->nextSibling)
        {
            $this->node->parentNode->insertBefore($fragment, $ref_node);
        } else {
            $this->node->parentNode->appendChild($fragment);
        }
    }

    /**
     * @param $str
     *
     * @return mixed
     */
    public function decamelize($str)
    {
        $str = \preg_replace_callback(
            '/(^|[a-z])([A-Z])/',
            function($matches) {
                return
                    \strtolower(
                        \strlen($matches[1])
                            ? $matches[1] . '_' . $matches[2] : $matches[2]
                    );
            },
            $str
        );

        return \preg_replace('/ /', '_', \strtolower($str));
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $ret = array();
        foreach ($this->node->attributes as $attr) {
            $ret[$attr->nodeName] = $attr->nodeValue;
        }

        return $ret;
    }

    /**
     * @param null $key
     * @param int  $level
     *
     * @return array
     */
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
            $ret[$this->decamelize(\implode(' ', \array_filter(array($key, $tag))))] = $this->text;
        } else {
            $flatten = [];
            foreach ($children as $child)
            {
                $flatten[] = $child->flatten(\implode(' ', \array_filter(array($key, $level <= 0 ? $tag : null))), $level - 1);
//                $ret = array_merge($ret, $child->flatten(implode(' ', array_filter(array($key, $level <= 0 ? $tag : null))), $level - 1));
            }

            $ret = \array_merge($ret, ...$flatten);
        }

        return $ret;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        switch ($name)
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
                foreach ($this->node->attributes as $_name => $att)
                {
                    $el->$_name = $att->nodeValue;
                }
                $this->node = $el->node;

                return;

        }

        $this->offsetSet($name, $value);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return true;
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->node->getAttribute($offset);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        if (\in_array($key, ['_path', 'dom', 'doc', 'node']))
        {
            return;
        }

        if ($value)
        {
            $this->node->setAttribute($key, $value);
            return;
        }

        $this->node->removeAttribute($key);
        //trigger_error('offsetSet not implemented', E_USER_WARNING);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        \trigger_error('offsetUnset not implemented', E_USER_WARNING);
    }

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->node->getAttribute('title');
    }
}
