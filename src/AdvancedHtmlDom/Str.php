<?php

namespace Bavix\AdvancedHtmlDom;

class Str
{
    /**
     * @var
     */
    protected $text;

    /**
     * Str constructor.
     *
     * @param $str
     */
    public function __construct($str)
    {
        $this->text = $str;
    }

    /**
     * @param     $regex
     * @param int $group_number
     *
     * @return bool
     */
    public function match($regex, $group_number = 0)
    {
        if (!\preg_match($regex, $this->text, $m))
        {
            return false;
        }

        return $m[$group_number];
    }

    /**
     * @param     $regex
     * @param int $group_number
     *
     * @return mixed
     */
    public function scan($regex, $group_number = 0)
    {
        \preg_match_all($regex, $this->text, $m);

        return $m[$group_number];
    }

    /**
     * @param     $regex
     * @param     $replacement
     * @param int $limit
     *
     * @return Str
     */
    public function gsub($regex, $replacement, $limit = -1)
    {
        if ($replacement instanceof \Closure)
        {
            $val = \preg_replace_callback($regex, $replacement, $this->text, $limit);
        }
        else
        {
            $val = \preg_replace($regex, $replacement, $this->text, $limit);
        }

        return new Str($val);
    }

    /**
     * @param $regex
     * @param $replacement
     *
     * @return Str
     */
    public function sub($regex, $replacement)
    {
        $val = $this->gsub($regex, $replacement, 1);

        return new Str($val);
    }

    /**
     * @param     $regex
     * @param int $limit
     *
     * @return array
     */
    public function split($regex, $limit = -1)
    {
        return \preg_split($regex, $this->text, $limit);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->text;
    }

    /**
     * @return mixed
     */
    public function to_s()
    {
        return $this->text;
    }

}
