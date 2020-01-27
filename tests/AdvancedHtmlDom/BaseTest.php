<?php

namespace Tests\AdvancedHtmlDom;

use Tests\Unit;
use function Bavix\AdvancedHtmlDom\strGetHtml;
use function Bavix\AdvancedHtmlDom\fileGetHtml;

class BaseTest extends Unit
{

    /**
     * @return void
     */
    public function testHelpers(): void
    {
        $file = fileGetHtml($this->partial('base.simple'));

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

    /**
     * @return void
     */
    public function testSimple(): void
    {
        $this->dom->loadFile($this->partial('base.simple'));

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

    /**
     * @return void
     */
    public function testId(): void
    {
        $this->dom->loadFile($this->partial('base.simple'));

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

    /**
     * @return void
     */
    public function testUl(): void
    {
        $this->dom->loadFile($this->partial('base.simple'));

        $ul = $this->dom->find('ul');

        $items = [];
        foreach ($ul as $ulItem) {
            foreach ($ulItem->childNodes as $childNode) {
                $items[] = (int)$childNode->innerText;
            }
        }

        $this->assertCount(3, $items);
        $this->assertEquals(6, array_sum($items));
    }

    /**
     * @return void
     */
    public function testPlaceholder(): void
    {
        $this->dom->loadFile($this->partial('base.simple'));
        $input = $this->dom->find('input[placeholder]');
        foreach ($input as $item) {
            $this->assertEquals($item->value, $item->placeholder);
        }
    }

}
