<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Throwable;

/**
 * Description of InsquareSeoExtension.
 *
 * @author: leogout
 */
class InsquareSeoExtension extends Extension
{
    public function getAlias(): string
    {
        return 'in_square_seo';
    }

    /**
     * @throws Throwable
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->loadIfConfigured('basic', $container, $loader, $config);
        $this->loadIfConfigured('og', $container, $loader, $config);
        $this->loadIfConfigured('twitter', $container, $loader, $config);

        $loader->load('services.xml');
    }

    /**
     * Checks if the configuration with this name isn't empty.
     * Creates a parameter and loads a configuration file of the given configuration name.
     *
     * @throws Throwable
     */
    private function loadIfConfigured(
        string $configName,
        ContainerBuilder $container,
        XmlFileLoader $loader,
        array $config
    ): void {
        if (!isset($config[$configName])) {
            return;
        }

        $mergedConfig = array_merge($config['general'], $config[$configName]);

        $container->setParameter(
            sprintf('in_square_seo.%s', $configName),
            $mergedConfig
        );

        $loader->load(sprintf('seo/%s.xml', $configName));
    }
}
