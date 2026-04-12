<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo;

/**
 * Description of KeywordsSeoInterface.
 *
 * @author: leogout
 */
interface KeywordsSeoInterface
{
    /**
     * @return string
     */
    public function getSeoKeywords() : string;
}
