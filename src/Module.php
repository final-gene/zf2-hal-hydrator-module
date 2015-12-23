<?php
/**
 * Module file
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModule;

use Zend\Config\Factory as ConfigFactory;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Module
 *
 * @package FinalGene\ZfHalHydratorModule
 */
class Module implements ConfigProviderInterface
{
    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [];
        $configFiles = [
            'config/service.config.php',
            'config/hydrator.config.php',
        ];

        foreach ($configFiles as $configFile) {
            $config = array_merge_recursive($config, $this->loadConfig($configFile));
        }

        return $config;
    }

    /**
     * Load config
     *
     * @param string $name Name of the configuration
     *
     * @throws \InvalidArgumentException if config could not be loaded
     *
     * @return array
     */
    protected function loadConfig($name)
    {
        $filename = __DIR__ . '/../' . $name;
        if (!is_readable($filename)) {
            throw new \InvalidArgumentException('Could not load config ' . $name);
        }

        /** @noinspection PhpIncludeInspection */
        return require $filename;
    }
}
