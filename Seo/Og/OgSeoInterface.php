<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo\Og;

use InSquare\SeoBundle\Seo\TitleSeoInterface;
use InSquare\SeoBundle\Seo\DescriptionSeoInterface;
use InSquare\SeoBundle\Seo\ImageSeoInterface;

/**
 * Description of OgSeoInterface.
 *
 * @author: leogout
 */
interface OgSeoInterface extends TitleSeoInterface, DescriptionSeoInterface, ImageSeoInterface
{
}
