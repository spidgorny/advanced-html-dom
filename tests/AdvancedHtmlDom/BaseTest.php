<?php

namespace Tests\AdvancedHtmlDom;

use Tests\Unit;

class BaseTest extends Unit
{

    public function testSimple()
    {
        $this->dom->loadFile(
            $this->partial('base.simple')
        );

        preg_match('~<h1.*>(.+)</h1>~', $this->dom->html(), $outs);

        $this->assertSame(
            $outs[0],
            (string)$this->dom->find('.hello:contains(\'' . $outs[1] . '\')')
        );

        $this->assertSame(
            $outs[0],
            $this->dom->find('h1')->html()
        );

        $this->assertSame(
            $outs[1],
            $this->dom->find('h1')->text()
        );
    }

    public function testId()
    {
        $this->dom->loadFile(
            $this->partial('base.simple')
        );

        $this->assertSame(
            $this->dom->find('#id')->tag,
            'body'
        );

        $this->assertSame(
            $this->dom->find('#id')->id,
            'id'
        );

        $this->assertSame(
            (string)$this->dom->find('.hello'),
            (string)$this->dom->find('.world')
        );
    }

}
