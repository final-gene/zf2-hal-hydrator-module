<?php
/**
 * This file is part of the zf-hal-hydrator-module.php project.
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest;

use FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity\ChildTestEntity;
use FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity\UnkownChildTestEntity;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 *
 * @package FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest
 */
class Module implements ConfigProviderInterface
{
    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return [
            'zf-hal' => [
                'renderer' => [
                    'default_hydrator' => 'FinalGene\ZfHalHydratorModule\Hydrator\HalEntityHydrator',
                ],
                'metadata_map' => [
                    ChildTestEntity::class => [
                        'force_self_link' => false,
                    ],
                    UnkownChildTestEntity::class => [
                        'force_self_link' => false,
                    ],
                ]
            ],
            'zf-hal-hydrator-module' => [
                'map' => [
                    'FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity\ChildTestEntity' => 'phpunit:test-entity'
                ]
            ]
        ];
    }
}
