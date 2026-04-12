<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Seo\Basic;

use InSquare\SeoBundle\Builder\TagBuilder;
use InSquare\SeoBundle\Factory\TagFactory;
use InSquare\SeoBundle\Seo\Basic\BasicSeoConfigurator;
use InSquare\SeoBundle\Seo\Basic\BasicSeoGenerator;
use InSquare\SeoBundle\Seo\Twitter\TwitterSeoGenerator;
use InSquare\SeoBundle\Tests\TestCase;

use InSquare\SeoBundle\Exception\InvalidSeoGeneratorException;

/**
 * Description of BasicSeoConfiguratorTest.
 *
 * @author: leogout
 */
class BasicSeoConfiguratorTest extends TestCase
{
    /**
     * @var BasicSeoGenerator
     */
    protected BasicSeoGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new BasicSeoGenerator(new TagBuilder(new TagFactory()));
    }

    public function testException()
    {
        $this->expectException(InvalidSeoGeneratorException::class);
        $this->expectExceptionMessage(sprintf(
            'Invalid seo generator passed to %s. Expected "%s", but got "%s".',
            BasicSeoConfigurator::class,
            BasicSeoGenerator::class,
            TwitterSeoGenerator::class
        ));

        $invalidGenerator = new TwitterSeoGenerator(new TagBuilder(new TagFactory()));
        $configurator = new BasicSeoConfigurator([]);
        $configurator->configure($invalidGenerator);
    }

    public function testTitle()
    {
        $config = [
            'title' => 'Awesome | Site'
        ];

        $configurator = new BasicSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<title>Awesome | Site</title>',
            $this->generator->render()
        );
    }

    public function testDescription()
    {
        $config = [
            'description' => 'My awesome site is so cool!',
        ];

        $configurator = new BasicSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta name="description" content="My awesome site is so cool!" />',
            $this->generator->render()
        );
    }

    public function testKeywords()
    {
        $config = [
            'keywords' => 'awesome, cool',
        ];

        $configurator = new BasicSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta name="keywords" content="awesome, cool" />',
            $this->generator->render()
        );
    }

    public function testCanonical()
    {
        $config = [
            'canonical' => 'https://example.com/canonical',
        ];

        $configurator = new BasicSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<link href="https://example.com/canonical" rel="canonical" />',
            $this->generator->render()
        );
    }

    public function testRobots()
    {
        $config = [
            'robots' => [
                'index' => true,
                'follow' => true,
            ],
        ];

        $configurator = new BasicSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '<meta name="robots" content="index, follow" />',
            $this->generator->render()
        );
    }

    public function testNoConfig()
    {
        $config = [];

        $configurator = new BasicSeoConfigurator($config);
        $configurator->configure($this->generator);

        $this->assertEquals(
            '',
            $this->generator->render()
        );
    }
}
