<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo\Basic;

use InSquare\SeoBundle\Seo\TitleSeoInterface;
use InSquare\SeoBundle\Seo\DescriptionSeoInterface;
use InSquare\SeoBundle\Seo\KeywordsSeoInterface;

/**
 * Description of BasicSeoInterface.
 *
 * @author: leogout
 */
interface BasicSeoInterface extends TitleSeoInterface, DescriptionSeoInterface, KeywordsSeoInterface
{
}
