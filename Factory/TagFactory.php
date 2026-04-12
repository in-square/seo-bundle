<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Factory;

use InSquare\SeoBundle\Model\LinkTag;
use InSquare\SeoBundle\Model\MetaTag;
use InSquare\SeoBundle\Model\TitleTag;

/**
 * Description of TagFactory.
 *
 * @author: leogout
 */
class TagFactory
{
    /**
     * @return TitleTag
     */
    public function createTitle() : TitleTag
    {
        return new TitleTag();
    }

    /**
     * @return MetaTag
     */
    public function createMeta() : MetaTag
    {
        return new MetaTag();
    }

    /**
     * @return LinkTag
     */
    public function createLink() : LinkTag
    {
        return new LinkTag();
    }
}
