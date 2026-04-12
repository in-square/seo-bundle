<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Description of SeoGeneratorPass.
 *
 * @author: leogout
 */
class SeoGeneratorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('insquare_seo.provider.generator');
        $taggedServices = $container->findTaggedServiceIds('insquare_seo.generator');

        foreach ($taggedServices as $id => $tags) {
            $generatorDefinition = $container->getDefinition($id);
            if ($generatorDefinition->isAbstract()) {
                throw new \InvalidArgumentException(sprintf('Seo generator services cannot be abstract but "%s" is.', $id));
            }
            foreach ($tags as $attributes) {
                if (empty($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('Tag "insquare_seo.generator" requires an "alias" field in "%s" definition.', $id));
                }

                $definition->addMethodCall('set', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
