<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo;

use InSquare\SeoBundle\Builder\TagBuilder;
use InSquare\SeoBundle\Model\RenderableInterface;

/**
 * Description of AbstractSeoGenerator.
 *
 * @author: leogout
 */
abstract class AbstractSeoGenerator implements RenderableInterface
{
    /**
     * @var TagBuilder
     */
    protected TagBuilder $tagBuilder;

    /**
     * BasicSeoBuilder constructor.
     *
     * @param TagBuilder $tagBuilder
     */
    public function __construct(TagBuilder $tagBuilder)
    {
        $this->tagBuilder = $tagBuilder;
    }

    /**
     * @return string
     */
    public function render() : string
    {
        return $this->tagBuilder->render();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
