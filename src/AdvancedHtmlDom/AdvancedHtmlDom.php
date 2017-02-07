<?php

namespace Deimos\AdvancedHtmlDom;

class AdvancedHtmlDom extends AdvancedHtmlBase
{
    public $xpath;
    public $root;

    public function __construct($html = null, $is_xml = false)
    {
        $this->doc = $this;
        if ($html)
        {
            $this->load($html, $is_xml);
        }
    }

    public function load($html, $is_xml = false)
    {
        $this->dom = new \DOMDocument();
        if ($is_xml)
        {
            @$this->dom->loadXML(preg_replace('/xmlns=".*?"/ ', '', $html));
        }
        else
        {
            @$this->dom->loadHTML($html);
        }
        $this->xpath = new DOMXPath($this->dom);
        //$this->root = new AHTMLNode($this->dom->documentElement, $this->doc);
        $this->root = $this->at('body');
    }

    public function load_file($file, $is_xml = false)
    {
        $this->load(file_get_contents($file), $is_xml);
    }

    // special cases
    public function text()
    {
        return $this->root->text;
    }

    public function title()
    {
        return $this->at('title')->text();
    }

}
