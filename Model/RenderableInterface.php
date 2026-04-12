<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Model;

/**
 * Description of MetaTagInterface.
 *
 * @author: leogout
 */
interface RenderableInterface
{
    /**
     * @return string
     */
    public function render() : string;

    /**
     * @return string
     */
    public function __toString(): string;
}
