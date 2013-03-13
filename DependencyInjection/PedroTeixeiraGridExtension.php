<?php

namespace PedroTeixeira\Bundle\GridBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PedroTeixeiraGridExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config['defaults'] as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $secondKey => $secondValue) {
                    $container->setParameter($this->getAlias() . '.' . $key . '.' . $secondKey, $secondValue);
                }
            } else {
                $container->setParameter($this->getAlias() . '.' . $key, $value);
            }
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'pedro_teixeira_grid';
    }
}
