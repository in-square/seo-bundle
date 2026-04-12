<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Twig;

use InSquare\SeoBundle\Model\RenderableInterface;
use InSquare\SeoBundle\Provider\SeoGeneratorProvider;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Description of SeoExtension.
 *
 * @author: leogout
 */
class SeoExtension extends AbstractExtension
{
    /**
     * @var SeoGeneratorProvider
     */
    protected SeoGeneratorProvider $generatorProvider;

    /**
     * SeoExtension constructor.
     *
     * @param SeoGeneratorProvider $generatorProvider
     */
    public function __construct(SeoGeneratorProvider $generatorProvider)
    {
        $this->generatorProvider = $generatorProvider;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('insquare_seo', [$this, 'seo'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param string|null $alias
     *
     * @return string
     */
    public function seo(?string $alias = null) : string
    {
        if (null !== $alias) {
            return $this->generatorProvider->get($alias)->render();
        }

        return implode(PHP_EOL,
            array_map(function (RenderableInterface $tag) {
                return $tag->render();
            }, $this->generatorProvider->getAll())
        );
    }

}
