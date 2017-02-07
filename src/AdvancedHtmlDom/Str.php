<?php

namespace Deimos\AdvancedHtmlDom;

class Str
{
    protected $text;

    public function __construct($str)
    {
        $this->text = $str;
    }

    public function match($regex, $group_number = 0)
    {
        if (!preg_match($regex, $this->text, $m))
        {
            return false;
        }

        return $m[$group_number];
    }

    public function scan($regex, $group_number = 0)
    {
        preg_match_all($regex, $this->text, $m);

        return $m[$group_number];
    }

    public function gsub($regex, $replacement, $limit = -1)
    {
        if ($replacement instanceof \Closure)
        {
            $val = preg_replace_callback($regex, $replacement, $this->text, $limit);
        }
        else
        {
            $val = preg_replace($regex, $replacement, $this->text, $limit);
        }

        return new Str($val);
    }

    public function sub($regex, $replacement)
    {
        $val = $this->gsub($regex, $replacement, 1);

        return new Str($val);
    }

    public function split($regex, $limit = -1)
    {
        return preg_split($regex, $this->text, $limit);
    }

    public function __toString()
    {
        return (string)$this->text;
    }

    public function to_s()
    {
        return $this->text;
    }

}
