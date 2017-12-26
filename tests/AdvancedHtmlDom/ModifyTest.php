<?php

namespace Tests\AdvancedHtmlDom;

use Tests\Unit;

class ModifyTest extends Unit
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSimple()
    {
        $this->dom->loadFile(
            $this->partial('base.simple')
        );

        $h1 = $this->dom->find('h1');

        $h1->class = __CLASS__;
    }

}
