<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Seo\Og;

use InSquare\SeoBundle\Builder\TagBuilder;
use InSquare\SeoBundle\Factory\TagFactory;
use InSquare\SeoBundle\Seo\Og\OgSeoConfigurator;
use InSquare\SeoBundle\Seo\Og\OgSeoGenerator;
use InSquare\SeoBundle\Seo\Twitter\TwitterSeoGenerator;
use InSquare\SeoBundle\Tests\TestCase;

use InSquare\SeoBundle\Exception\InvalidSeoGeneratorException;

/**
 * Description of OgSeoConfiguratorTest.
 *
 * @author: leogout
 */
class OgSeoConfiguratorTest extends TestCase
{
    /**
     * @var OgSeoGenerator
     */
    protected OgSeoGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new OgSeoGenerator(new TagBuilder(new TagFactory()));
    }

    public function testException()
    {
        $this->expectException(InvalidSeoGeneratorException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid seo generator passed to %s. Expected "%s", but got "%s".',
            OgSeoConfigurator::class,
            OgSeoGenerator::class,
            TwitterSeoGenerator::class
        ));

        $invalidGenerator = new TwitterSeoGenerator(new TagBuilder(new TagFactory()));
        $configurator = new OgSeoConfigurator([]);
        $configurator->configure($invalidGenerator);
    }

    public function testTitle()
    {
        $config = [
            'title' => 'Awesome | Site'
        ];

        $configurator = new OgSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta property="og:title" content="Awesome | Site" />',
            $this->generator->render()
        );
    }

    public function testDescription()
    {
        $config = [
            'description' => 'My awesome site is so cool!',
        ];

        $configurator = new OgSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta property="og:description" content="My awesome site is so cool!" />',
            $this->generator->render()
        );
    }

    public function testImage()
    {
        $config = [
            'image' => 'https://example.com/poney/12',
        ];

        $configurator = new OgSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta property="og:image" content="https://example.com/poney/12" />',
            $this->generator->render()
        );
    }

    public function testType()
    {
        $config = [
            'type' => 'website',
        ];

        $configurator = new OgSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta property="og:type" content="website" />',
            $this->generator->render()
        );
    }

    public function testNoConfig()
    {
        $config = [];

        $configurator = new OgSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '',
            $this->generator->render()
        );
    }
}
