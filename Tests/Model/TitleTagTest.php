<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Model;

use InSquare\SeoBundle\Model\TitleTag;
use InSquare\SeoBundle\Tests\TestCase;

/**
 * Description of TitleTagTest.
 *
 * @author: leogout
 */
class TitleTagTest extends TestCase
{
    public function testNullValues()
    {
        $titleTag = new TitleTag();
        $this->assertNull($titleTag->getContent());
    }

    public function testRender()
    {
        $titleTag = new TitleTag();
        $titleTag->setContent('Awesonme | Site');

        $this->assertEquals(
            '<title>Awesonme | Site</title>',
            $titleTag->render()
        );
    }

    public function testRenderTitleOnly()
    {
        $titleTag = new TitleTag();
        $titleTag
            ->setContent('Site');

        $this->assertEquals(
            '<title>Site</title>',
            $titleTag->render()
        );
    }

    public function testRenderNothing()
    {
        $titleTag = new TitleTag();

        $this->assertEquals(
            '<title></title>',
            $titleTag->render()
        );
    }

    public function testRenderEscapesHtml()
    {
        $titleTag = new TitleTag();
        $titleTag->setContent('<script>alert("x")</script>');

        $this->assertEquals(
            '<title>&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt;</title>',
            $titleTag->render()
        );
    }
}
