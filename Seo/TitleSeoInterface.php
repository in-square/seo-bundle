<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo;

/**
 * Description of TitleSeoInterface.
 *
 * @author: leogout
 */
interface TitleSeoInterface
{
    /**
     * @return string
     */
    public function getSeoTitle() : string;
}
