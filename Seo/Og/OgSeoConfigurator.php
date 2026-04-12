<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Seo\Og;

use InSquare\SeoBundle\Exception\InvalidSeoGeneratorException;
use InSquare\SeoBundle\Seo\AbstractSeoConfigurator;
use InSquare\SeoBundle\Seo\AbstractSeoGenerator;

/**
 * Description of OgSeoConfigurator.
 *
 * @author: leogout
 */
class OgSeoConfigurator extends AbstractSeoConfigurator
{
    /**
     * @param AbstractSeoGenerator $generator
     */
    public function configure(AbstractSeoGenerator $generator) : void
    {
        if (!($generator instanceof OgSeoGenerator)) {
            throw new InvalidSeoGeneratorException(__CLASS__, OgSeoGenerator::class, get_class($generator));
        }
        if (null !== $title = $this->getConfig('title')) {
            $generator->setTitle($title);
        }
        if (null !== $description = $this->getConfig('description')) {
            $generator->setDescription($description);
        }
        if (null !== $image = $this->getConfig('image')) {
            $generator->setImage($image);
        }
        if (null !== $type = $this->getConfig('type')) {
            $generator->setType($type);
        }
        if (null !== $url = $this->getConfig('url')) {
            $generator->setUrl($url);
        }
    }
}
