<?php
/**
 * This file is part of the zf-hal-hydrator-module.php project.
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModule\Hydrator;

use FinalGene\ZfHalHydratorModule\Hydrator\NamingStrategy\MapNamingStrategy;
use FinalGene\ZfHalHydratorModule\Options\ModuleOptions;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Reflection;

/**
 * Class RestEntityHydratorFactory
 *
 * @package FinalGene\ZfHalHydratorModule\Hydrator
 */
class HalEntityHydratorFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Reflection
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var Reflection $reflectionHydrator */
        $reflectionHydrator = $serviceLocator->get('reflection');

        /** @var ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->getServiceLocator()->get(ModuleOptions::class);

        $map = $moduleOptions->getMap();

        if (count($map) > 0) {
            $flippedMap = array_flip($map);

            if (false !== $flippedMap) {
                $reflectionHydrator->setNamingStrategy(
                    new MapNamingStrategy($flippedMap)
                );
            }
        }

        return $reflectionHydrator;
    }
}
