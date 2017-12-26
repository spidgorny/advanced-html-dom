<?php

namespace Tests\AdvancedHtmlDom;

use Tests\Unit;
use function Bavix\AdvancedHtmlDom\strGetHtml;
use function Bavix\AdvancedHtmlDom\fileGetHtml;

class BaseTest extends Unit
{

    public function testHelpers()
    {
        $file = fileGetHtml(
            $this->partial('base.simple')
        );

        $str = strGetHtml(
            \file_get_contents(
                $this->partial('base.simple')
            )
        );

        $this->assertSame(
            $file->html(),
            $str->html()
        );
    }

    public function testSimple()
    {
        $this->dom->loadFile(
            $this->partial('base.simple')
        );

        preg_match('~<h1.*>(.+)</h1>~', $this->dom->html(), $outs);

        $this->assertSame(
            $outs[0],
            (string)$this->dom->find('h1:contains(\'' . $outs[1] . '\')')
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
            (string)$this->dom->find('.h'),
            (string)$this->dom->find('.w')
        );
    }

    public function testUl()
    {
        $this->dom->loadFile(
            $this->partial('base.simple')
        );

        $ul = $this->dom->find('ul');

//        var_dump($ul->());die;

//        foreach ($li as $item)
//        {
//
//        }

    }

}
