<?php

namespace Tests;

use Bavix\AdvancedHtmlDom\AdvancedHtmlDom;

class Unit extends \Bavix\Tests\Unit
{

    /**
     * @var AdvancedHtmlDom
     */
    protected $dom;

    public function setUp()
    {
        parent::setUp();

        $this->dom = new AdvancedHtmlDom();
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function partial(string $path): string
    {
        return __DIR__ . '/data/' . \str_replace('.', '/', $path) . '.html';
    }

}
