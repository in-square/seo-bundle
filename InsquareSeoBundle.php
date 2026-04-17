<?php

declare(strict_types=1);

namespace InSquare\SeoBundle;

use InSquare\SeoBundle\DependencyInjection\Compiler\SeoGeneratorPass;
use InSquare\SeoBundle\DependencyInjection\InsquareSeoExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class InsquareSeoBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SeoGeneratorPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (!isset($this->extension)) {
            $this->extension = new InsquareSeoExtension();
        }

        return $this->extension ?: null;
    }
}
