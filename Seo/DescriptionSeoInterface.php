<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo;

/**
 * Description of DescriptionSeoInterface.
 *
 * @author: leogout
 */
interface DescriptionSeoInterface
{
    /**
     * @return string
     */
    public function getSeoDescription() : string;
}
