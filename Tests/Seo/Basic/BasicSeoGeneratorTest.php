<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Seo\Basic;

use InSquare\SeoBundle\Builder\TagBuilder;
use InSquare\SeoBundle\Factory\TagFactory;
use InSquare\SeoBundle\Model\MetaTag;
use InSquare\SeoBundle\Model\TitleTag;
use InSquare\SeoBundle\Seo\Basic\BasicSeoGenerator;
use InSquare\SeoBundle\Seo\Basic\BasicSeoInterface;
use InSquare\SeoBundle\Tests\TestCase;

/**
 * Description of BasicSeoGeneratorTest.
 *
 * @author: leogout
 */
class BasicSeoGeneratorTest extends TestCase
{
    /**
     * @var BasicSeoGenerator
     */
    protected BasicSeoGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new BasicSeoGenerator(new TagBuilder(new TagFactory()));
    }

    public function testTitle()
    {
        $this->generator->setTitle('Awesome site');

        $this->assertEquals(
            '<title>Awesome site</title>',
            $this->generator->render()
        );

        $this->assertInstanceOf(
            TitleTag::class, $this->generator->getTitle()
        );
    }

    public function testDescription()
    {
        $this->assertNull($this->generator->getDescription());

        $this->generator->setDescription('My awesome site is so cool!');

        $this->assertEquals(
            '<meta name="description" content="My awesome site is so cool!" />',
            $this->generator->render()
        );

        $this->assertInstanceOf(
            MetaTag::class, $this->generator->getDescription()
        );
    }

    public function testKeywords()
    {
        $this->assertNull($this->generator->getKeywords());

        $this->generator->setKeywords('awesome, cool');

        $this->assertEquals(
            '<meta name="keywords" content="awesome, cool" />',
            $this->generator->render()
        );

        $this->assertInstanceOf(
            MetaTag::class, $this->generator->getKeywords()
        );
    }

    public function testCanonical()
    {
        $this->assertNull($this->generator->getCanonical());

        $this->generator->setCanonical('https://example.com/canonical');

        $this->assertEquals(
            '<link href="https://example.com/canonical" rel="canonical" />',
            $this->generator->render()
        );
    }

    public function testAmpHtml()
    {
        $this->assertNull($this->generator->getAmpHtml());

        $this->generator->setAmpHtml('https://example.com/foo/bar');

        $this->assertEquals(
            '<link href="https://example.com/foo/bar" rel="amphtml" />',
            $this->generator->render()
        );
    }

    public function testRobots()
    {
        $this->assertNull($this->generator->getRobots());

        $this->generator->setRobots(true, true);

        $this->assertEquals(
            '<meta name="robots" content="index, follow" />',
            $this->generator->render()
        );

        $this->generator->setRobots(false, false);

        $this->assertEquals(
            '<meta name="robots" content="noindex, nofollow" />',
            $this->generator->render()
        );

        $this->generator->setRobots(true, false);

        $this->assertEquals(
            '<meta name="robots" content="index, nofollow" />',
            $this->generator->render()
        );

        $this->generator->setRobots(false, true);

        $this->assertEquals(
            '<meta name="robots" content="noindex, follow" />',
            $this->generator->render()
        );

        $this->assertInstanceOf(MetaTag::class, $this->generator->getRobots());
    }

    public function testFromResource()
    {
        $this->assertEmpty($this->generator->render());

        $resource = $this->getMockBuilder(BasicSeoInterface::class)->getMock();

        $resource->method('getSeoTitle')->willReturn('Awesome site');
        $resource->method('getSeoDescription')->willReturn('My awesome site is so cool!');
        $resource->method('getSeoKeywords')->willReturn('awesome, cool');

        $this->generator->fromResource($resource);

        $this->assertEquals(
            "<title>Awesome site</title>\n".
            "<meta name=\"description\" content=\"My awesome site is so cool!\" />\n".
            "<meta name=\"keywords\" content=\"awesome, cool\" />",
            $this->generator->render()
        );
    }

    public function testRenderNothing()
    {
        $this->assertEquals(
            '',
            $this->generator->render()
        );
    }
}
