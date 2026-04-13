<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Tests\DependencyInjection\Compiler;

use InSquare\SeoBundle\DependencyInjection\Compiler\SeoGeneratorPass;
use InSquare\SeoBundle\Provider\SeoGeneratorProvider;
use InSquare\SeoBundle\Seo\Basic\BasicSeoGenerator;
use InSquare\SeoBundle\Tests\TestCase;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Description of SeoGeneratorPassTest.
 *
 * @author: leogout
 */
class SeoGeneratorPassTest extends TestCase
{
    public function testFailsWhenServiceIsAbstract()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Seo generator services cannot be abstract but "id" is.');

        $container = new ContainerBuilder();
        $container->setDefinition('in_square_seo.provider.generator', new Definition(SeoGeneratorProvider::class));

        $generatorDefinition = new Definition(BasicSeoGenerator::class);
        $generatorDefinition->setAbstract(true);
        $generatorDefinition->addTag('in_square_seo.generator', ['alias' => 'foo']);
        $container->setDefinition('id', $generatorDefinition);

        (new SeoGeneratorPass())->process($container);
    }

    public function testFailsWhenAliasIsMissing()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Tag "in_square_seo.generator" requires an "alias" field in "id" definition.');

        $container = new ContainerBuilder();
        $container->setDefinition('in_square_seo.provider.generator', new Definition(SeoGeneratorProvider::class));

        $generatorDefinition = new Definition(BasicSeoGenerator::class);
        $generatorDefinition->addTag('in_square_seo.generator', ['alias' => '']);
        $container->setDefinition('id', $generatorDefinition);

        (new SeoGeneratorPass())->process($container);
    }

    public function testRegistersPrivateGeneratorAlias()
    {
        $container = new ContainerBuilder();
        $providerDefinition = new Definition(SeoGeneratorProvider::class);
        $container->setDefinition('in_square_seo.provider.generator', $providerDefinition);

        $generatorDefinition = new Definition(BasicSeoGenerator::class);
        $generatorDefinition->setPublic(false);
        $generatorDefinition->addTag('in_square_seo.generator', ['alias' => 'basic']);
        $container->setDefinition('id', $generatorDefinition);

        (new SeoGeneratorPass())->process($container);

        $calls = $providerDefinition->getMethodCalls();
        $this->assertCount(1, $calls);
        $this->assertSame('set', $calls[0][0]);
        $this->assertSame('basic', $calls[0][1][0]);
        $this->assertInstanceOf(Reference::class, $calls[0][1][1]);
        $this->assertSame('id', (string) $calls[0][1][1]);
    }
}
