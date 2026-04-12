<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Exception;

/**
 * Description of InvalidSeoGeneratorException
 *
 * @author: leogout
 */
class InvalidSeoGeneratorException extends \InvalidArgumentException
{
    public function __construct(string $configurator, string $expectedGenerator, string $givenGenerator)
    {
        parent::__construct(
            sprintf(
                'Invalid seo generator passed to %s. Expected "%s", but got "%s".',
                $configurator,
                $expectedGenerator,
                $givenGenerator
            )
        );
    }
}
