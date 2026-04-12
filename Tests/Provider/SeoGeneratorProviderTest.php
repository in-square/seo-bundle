<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Provider;

use InSquare\SeoBundle\Builder\TagBuilder;
use InSquare\SeoBundle\Factory\TagFactory;
use InSquare\SeoBundle\Provider\SeoGeneratorProvider;
use InSquare\SeoBundle\Seo\Basic\BasicSeoGenerator;
use InSquare\SeoBundle\Tests\TestCase;

use InvalidArgumentException;

/**
 * Description of SeoGeneratorProviderTest.
 *
 * @author: leogout
 */
class SeoGeneratorProviderTest extends TestCase
{
    /**
     * @var SeoGeneratorProvider
     */
    protected SeoGeneratorProvider $provider;

    protected function setUp(): void
    {
        $tagBuilder = new TagBuilder(new TagFactory());
        $basicGenerator = new BasicSeoGenerator($tagBuilder);

        $this->provider = new SeoGeneratorProvider();

        $this->provider->set('basic', $basicGenerator);
    }

    public function testGetGenerator()
    {
        $this->assertInstanceOf(
            BasicSeoGenerator::class,
            $this->provider->get('basic')
        );
    }

    public function testGetUndefinedGenerator()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The SEO generator with alias "undefined" is not defined.');
        $this->provider->get('undefined');
    }

    public function testGetAllGenerators()
    {
        $this->assertInstanceOf(
            BasicSeoGenerator::class,
            $this->provider->getAll()['basic']
        );
    }

    public function testHasGenerator()
    {
        $this->assertTrue(
            $this->provider->has('basic')
        );
        $this->assertFalse(
            $this->provider->has('undefined')
        );
    }
}
