<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Model;

use InSquare\SeoBundle\Model\LinkTag;
use InSquare\SeoBundle\Tests\TestCase;
use InvalidArgumentException;

/**
 * Description of LinkTagTest.
 *
 * @author: leogout
 */
class LinkTagTest extends TestCase
{
    public function testNullValues()
    {
        $linkTag = new LinkTag();

        $this->assertNull($linkTag->getHref());
        $this->assertNull($linkTag->getRel());
        $this->assertNull($linkTag->getType());
        $this->assertNull($linkTag->getTitle());
        $this->assertSame([], $linkTag->getAttributes());
    }

    public function testRenderAll()
    {
        $linkTag = new LinkTag();
        $linkTag
            ->setHref('https://example.com/blog')
            ->setRel('alternate')
            ->setType('application/rss+xml')
            ->setTitle('RSS');

        $this->assertEquals(
            '<link href="https://example.com/blog" rel="alternate" type="application/rss+xml" title="RSS" />',
            $linkTag->render()
        );
    }

    public function testRenderHrefAndRel()
    {
        $linkTag = new LinkTag();
        $linkTag
            ->setHref('https://example.com/blog')
            ->setRel('alternate');

        $this->assertEquals(
            '<link href="https://example.com/blog" rel="alternate" />',
            $linkTag->render()
        );
    }

    public function testRenderTypeAndTitle()
    {
        $linkTag = new LinkTag();
        $linkTag
            ->setType('application/rss+xml')
            ->setTitle('RSS');

        $this->assertEquals(
            '<link type="application/rss+xml" title="RSS" />',
            $linkTag->render()
        );
    }

    public function testRenderNothing()
    {
        $linkTag = new LinkTag();
        $this->assertEquals(
            '<link />',
            $linkTag->render()
        );
    }

    public function testRenderWithCustomAttributes()
    {
        $linkTag = new LinkTag();
        $linkTag
            ->setHref('https://example.com/page-en')
            ->setRel('alternate')
            ->setAttribute('hreflang', 'en')
            ->setAttribute('data-region', 'global');

        $this->assertEquals(
            '<link href="https://example.com/page-en" rel="alternate" hreflang="en" data-region="global" />',
            $linkTag->render()
        );
    }

    public function testAddAttributesRemovesEmptyValues()
    {
        $linkTag = new LinkTag();
        $linkTag->addAttributes([
            'hreflang' => 'pl',
            'title' => '',
        ]);

        $this->assertSame('pl', $linkTag->getAttribute('hreflang'));
        $this->assertNull($linkTag->getAttribute('title'));
    }

    public function testRenderEscapesHtmlInValues()
    {
        $linkTag = new LinkTag();
        $linkTag
            ->setHref('https://example.com/page-pl?x="1"&y=<2>')
            ->setRel('alternate')
            ->setAttribute('hreflang', 'pl"><script>alert(1)</script>');

        $this->assertEquals(
            '<link href="https://example.com/page-pl?x=&quot;1&quot;&amp;y=&lt;2&gt;" rel="alternate" hreflang="pl&quot;&gt;&lt;script&gt;alert(1)&lt;/script&gt;" />',
            $linkTag->render()
        );
    }

    public function testSetAttributeRejectsInvalidName()
    {
        $this->expectException(InvalidArgumentException::class);

        $linkTag = new LinkTag();
        $linkTag->setAttribute('invalid name', 'value');
    }
}
