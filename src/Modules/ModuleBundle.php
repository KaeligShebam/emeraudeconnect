<?php

namespace App\Modules;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ModuleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->loadModuleConfigurations($container);
    }

    private function loadModuleConfigurations(ContainerBuilder $container)
    {
        $modulesDir = __DIR__ . '/../../../Modules';

        $finder = new \Symfony\Component\Finder\Finder();
        $finder->directories()->in($modulesDir);

        foreach ($finder as $moduleDir) {
            $moduleConfigFile = $moduleDir->getPathname() . '/config.yaml';

            if (file_exists($moduleConfigFile)) {
                $loader = new YamlFileLoader($container, new FileLocator($moduleDir->getPathname()));
                $loader->load('config.yaml');
            }
        }
    }
}
