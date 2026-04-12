<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Model;

use InSquare\SeoBundle\Model\MetaTag;
use InSquare\SeoBundle\Tests\TestCase;

use InvalidArgumentException;

/**
 * Description of MetaTagTest.
 *
 * @author: leogout
 */
class MetaTagTest extends TestCase
{
    public function testNullValues()
    {
        $metaTag = new MetaTag();
        $this->assertNull($metaTag->getValue());
        $this->assertNull($metaTag->getContent());
        $this->assertSame([], $metaTag->getAttributes());
    }

    public function testRenderName()
    {
        $metaTag = new MetaTag();
        $metaTag
            ->setType(MetaTag::NAME_TYPE)
            ->setValue('keywords')
            ->setContent('your, tags');

        $this->assertEquals(
            '<meta name="keywords" content="your, tags" />',
            $metaTag->render()
        );
    }

    public function testRenderProperty()
    {
        $metaTag = new MetaTag();
        $metaTag
            ->setType(MetaTag::PROPERTY_TYPE)
            ->setValue('og:title')
            ->setContent('My awesome site');

        $this->assertEquals(
            '<meta property="og:title" content="My awesome site" />',
            $metaTag->render()
        );
    }

    public function testRenderHttpEquiv()
    {
        $metaTag = new MetaTag();
        $metaTag
            ->setType(MetaTag::HTTP_EQUIV_TYPE)
            ->setValue('Cache-Control')
            ->setContent('no-cache');

        $this->assertEquals(
            '<meta http-equiv="Cache-Control" content="no-cache" />',
            $metaTag->render()
        );
    }

    public function testRenderNothing()
    {
        $metaTag = new MetaTag();

        $this->assertEquals(
            '<meta name="" content="" />',
            $metaTag->render()
        );
    }

    public function testSetUnknownType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Meta tag of type "unknownType" doesn\'t exist. Existing types are: name, property and http-equiv.');

        $metaTag = new MetaTag();
        $metaTag->setType('unknownType');
    }

    public function testRenderWithCustomAttributes()
    {
        $metaTag = new MetaTag();
        $metaTag
            ->setType(MetaTag::NAME_TYPE)
            ->setValue('robots')
            ->setContent('index,follow')
            ->setAttribute('data-variant', 'custom');

        $this->assertEquals(
            '<meta name="robots" content="index,follow" data-variant="custom" />',
            $metaTag->render()
        );
    }

    public function testRenderEscapesHtmlInValues()
    {
        $metaTag = new MetaTag();
        $metaTag
            ->setType(MetaTag::NAME_TYPE)
            ->setValue('description')
            ->setContent('A "quote" <script>alert(1)</script>')
            ->setAttribute('data-test', '\'><img src=x onerror=alert(1)>');

        $this->assertEquals(
            '<meta name="description" content="A &quot;quote&quot; &lt;script&gt;alert(1)&lt;/script&gt;" data-test="&#039;&gt;&lt;img src=x onerror=alert(1)&gt;" />',
            $metaTag->render()
        );
    }

    public function testSetAttributeRejectsInvalidName()
    {
        $this->expectException(InvalidArgumentException::class);

        $metaTag = new MetaTag();
        $metaTag->setAttribute('onload foo', 'bar');
    }
}
