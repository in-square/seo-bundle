<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\Twig;

use InSquare\SeoBundle\Builder\TagBuilder;
use InSquare\SeoBundle\Factory\TagFactory;
use InSquare\SeoBundle\Provider\SeoGeneratorProvider;
use InSquare\SeoBundle\Seo\AbstractSeoGenerator;
use InSquare\SeoBundle\Seo\Basic\BasicSeoGenerator;
use InSquare\SeoBundle\Tests\TestCase;
use InSquare\SeoBundle\Twig\SeoExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class SeoExtensionTest extends TestCase
{
    protected Environment $twig;
    protected SeoGeneratorProvider $provider;

    protected function setUp(): void
    {
        $loader = new ArrayLoader([
            'index' => '<!-- start -->{{ insquare_seo() }}<!-- end -->'
        ]);

        $tagBuilder = new TagBuilder(new TagFactory());
        $basicGenerator = new BasicSeoGenerator($tagBuilder);

        $this->provider = new SeoGeneratorProvider();

        $this->provider->set('basic', $basicGenerator);

        $this->twig = new Environment($loader);
        $this->twig->addExtension(new SeoExtension($this->provider));
    }

    public function testSeoTwigFunction()
    {
        $this->assertEquals('<!-- start --><!-- end -->', $this->twig->render('index'));

        /**
         * @var $basicSeo BasicSeoGenerator
         */
        $basicSeo = $this->provider->get('basic')->setTitle('example');

        $this->assertEquals('<!-- start --><title>example</title><!-- end -->',
            $this->twig->render('index'));

        $basicSeo->setDescription('it works!');

        $this->assertEquals('<!-- start --><title>example</title>' . PHP_EOL .
            '<meta name="description" content="it works!" /><!-- end -->', $this->twig->render('index'));
    }

    public function testSeoTwigFunctionRendersCustomLinkAttributeThroughProvider()
    {
        $loader = new ArrayLoader([
            'alternate' => '<!-- start -->{{ insquare_seo(\'alternate\') }}<!-- end -->'
        ]);

        $provider = new SeoGeneratorProvider();

        $alternateSeo = new class(new TagBuilder(new TagFactory())) extends AbstractSeoGenerator {
            public function setAlternateLink(string $href, string $hreflang): self
            {
                $this->tagBuilder->addLink(
                    sprintf('alternate_%s', $hreflang),
                    $href,
                    'alternate',
                    null,
                    null,
                    ['hreflang' => $hreflang]
                );

                return $this;
            }
        };

        $provider->set('alternate', $alternateSeo->setAlternateLink('https://example.com/pl', 'pl'));

        $twig = new Environment($loader);
        $twig->addExtension(new SeoExtension($provider));

        $this->assertEquals(
            '<!-- start --><link href="https://example.com/pl" rel="alternate" hreflang="pl" /><!-- end -->',
            $twig->render('alternate')
        );
    }

    public function testSeoTwigFunctionWithoutAliasRendersAllGeneratorsIncludingCustomAttributes()
    {
        $loader = new ArrayLoader([
            'all' => '<!-- start -->{{ insquare_seo() }}<!-- end -->'
        ]);

        $provider = new SeoGeneratorProvider();

        $basicSeo = new BasicSeoGenerator(new TagBuilder(new TagFactory()));
        $basicSeo->setTitle('example');

        $alternateSeo = new class(new TagBuilder(new TagFactory())) extends AbstractSeoGenerator {
            public function setAlternateLink(string $href, string $hreflang): self
            {
                $this->tagBuilder->addLink(
                    sprintf('alternate_%s', $hreflang),
                    $href,
                    'alternate',
                    null,
                    null,
                    ['hreflang' => $hreflang]
                );

                return $this;
            }
        };

        $provider->set('basic', $basicSeo);
        $provider->set('alternate', $alternateSeo->setAlternateLink('https://example.com/pl', 'pl'));

        $twig = new Environment($loader);
        $twig->addExtension(new SeoExtension($provider));

        $this->assertEquals(
            '<!-- start --><title>example</title>' . PHP_EOL .
            '<link href="https://example.com/pl" rel="alternate" hreflang="pl" /><!-- end -->',
            $twig->render('all')
        );
    }
}
