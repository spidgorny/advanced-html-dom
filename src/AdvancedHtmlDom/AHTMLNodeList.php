<?php

namespace Bavix\AdvancedHtmlDom;

class AHTMLNodeList implements \Iterator, \Countable, \ArrayAccess
{

    /**
     * @var
     */
    private $nodeList;

    /**
     * @var
     */
    private $doc;

    /**
     * @var int
     */
    private $counter = 0;

    /**
     * AHTMLNodeList constructor.
     *
     * @param $nodeList
     * @param $doc
     */
    public function __construct($nodeList, $doc)
    {
        $this->nodeList = $nodeList;
        $this->doc      = $doc;
    }

    /**
     * @see https://github.com/monkeysuffrage/advanced_html_dom/issues/19
     */
    public function __destruct()
    {
        $this->nodeList = $this->doc = null;
        unset($this->nodeList, $this->doc);
        Cleanup::all();
    }

    /*
    abstract public boolean offsetExists ( mixed $offset )
    abstract public mixed offsetGet ( mixed $offset )
    abstract public void offsetSet ( mixed $offset , mixed $value )
    abstract public void offsetUnset ( mixed $offset )
    */

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return 0 <= $offset && $offset < $this->nodeList->length;
    }

    /**
     * @param mixed $offset
     *
     * @return AHTMLNode
     */
    public function offsetGet($offset)
    {
        return new AHTMLNode($this->nodeList->item($offset), $this->doc);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        \trigger_error('offsetSet not implemented', E_USER_WARNING);
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
    public function count()
    {
        return $this->nodeList->length;
    }

    /**
     *
     */
    public function rewind()
    {
        $this->counter = 0;
    }

    /**
     * @return AHTMLNode
     */
    public function current()
    {
        return new AHTMLNode($this->nodeList->item($this->counter), $this->doc);
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->counter;
    }

    /**
     *
     */
    public function next()
    {
        $this->counter++;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->nodeList && $this->counter < $this->nodeList->length;
    }

    /**
     * @return AHTMLNode|null
     */
    public function last()
    {
        return ($this->nodeList->length > 0) ? new AHTMLNode($this->nodeList->item($this->nodeList->length - 1), $this->doc) : null;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        foreach ($this as $node)
        {
            $node->remove();
        }

        return $this;
    }

    /**
     * @param $c
     *
     * @return array
     */
    public function map($c)
    {
        $ret = array();
        foreach ($this as $node)
        {
            $ret[] = $c($node);
        }

        return $ret;
    }


    //math methods

    /**
     * @param        $nl
     * @param string $op
     *
     * @return AHTMLNodeList
     */
    public function doMath($nl, $op = 'plus')
    {
        $paths       = array();
        $other_paths = array();

        foreach ($this as $node)
        {
            $paths[] = $node->node->getNodePath();
        }
        foreach ($nl as $node)
        {
            $other_paths[] = $node->node->getNodePath();
        }
        switch ($op)
        {
            case 'plus':
                $new_paths = \array_unique(\array_merge($paths, $other_paths));
                break;
            case 'minus':
                $new_paths = \array_diff($paths, $other_paths);
                break;
            case 'intersect':
                $new_paths = \array_intersect($paths, $other_paths);
                break;
        }

        return new AHTMLNodeList($this->doc->xpath->query(implode('|', $new_paths)), $this->doc);
    }

    /**
     * @param $nl
     *
     * @return AHTMLNodeList
     */
    public function minus($nl)
    {
        return $this->doMath($nl, 'minus');
    }

    /**
     * @param $nl
     *
     * @return AHTMLNodeList
     */
    public function plus($nl)
    {
        return $this->doMath($nl, 'plus');
    }

    /**
     * @param $nl
     *
     * @return AHTMLNodeList
     */
    public function intersect($nl)
    {
        return $this->doMath($nl, 'intersect');
    }


    // magic methods

    /**
     * @param $key
     * @param $values
     *
     * @return array|string
     */
    public function __call($key, $values)
    {
        $key = \strtolower(\str_replace('_', '', $key));
        switch ($key)
        {
            case 'to_a':
                $retval = array();
                foreach ($this as $node)
                {
                    $retval[] = new AHTMLNode($this->nodeList->item($this->counter), $this->doc);
                }

                return $retval;
        }
        // otherwise

        $retval = array();

        /*
            if(preg_match(TAGS_REGEX, $key, $m)) return $this->find($m[1]);
            if(preg_match(TAG_REGEX, $key, $m)) return $this->find($m[1], 0);
        */

        if (\preg_match(ATTRIBUTES_REGEX, $key, $m) || \preg_match('/^((clean|trim|str).*)s$/', $key, $m))
        {
            foreach ($this as $node)
            {
                $arg      = $m[1];
                $retval[] = $node->$arg;
            }

            return $retval;
        }

        if (\preg_match(ATTRIBUTE_REGEX, $key, $m))
        {
            foreach ($this as $node)
            {
                $arg      = $m[1];
                $retval[] = $node->$arg;
            }

            return \implode('', $retval);
        }

        // what now?
        foreach ($this as $node)
        {
            $retval[] = isset($values[0]) ? $node->$key($values[0]) : $node->$key();
        }

        return \implode('', $retval);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->$key();
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        throw new \InvalidArgumentException(__METHOD__);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->html();
    }

    /**
     * @return mixed
     */
    public function length()
    {
        return $this->nodeList->length;
    }
}
