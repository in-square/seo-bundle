<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo\Twitter;

use InSquare\SeoBundle\Seo\TitleSeoInterface;
use InSquare\SeoBundle\Seo\DescriptionSeoInterface;
use InSquare\SeoBundle\Seo\ImageSeoInterface;

/**
 * Description of TwitterSeoInterface.
 *
 * @author: leogout
 */
interface TwitterSeoInterface extends TitleSeoInterface, DescriptionSeoInterface, ImageSeoInterface
{
}
