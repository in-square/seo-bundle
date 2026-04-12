<?php

declare(strict_types=1);

namespace InSquare\SeoBundle;

use InSquare\SeoBundle\DependencyInjection\Compiler\SeoGeneratorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class InsquareSeoBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SeoGeneratorPass());
    }
}
