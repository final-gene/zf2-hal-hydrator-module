<?php
/**
 * This file is part of the zf-hal-hydrator-module.php project.
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */
namespace FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator;
use FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity\ChildTestEntity;
use FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity\RootTestEntity;
use FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity\UnkownChildTestEntity;
use Zend\Test\Util\ModuleLoader;
use ZF\Hal\Collection;
use ZF\Hal\Entity;
use ZF\Hal\Plugin\Hal;

/**
 * Class HalEntityHydratorTest
 *
 * @package Integration\Hydrator
 */
class HalEntityHydratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleLoader
     */
    protected $moduleLoader;

    protected function setUp()
    {
        $this->moduleLoader = new ModuleLoader([
            'modules' => [
                'ZF\Hal',
                'FinalGene\ZfHalHydratorModule',
                'FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest',
            ],
            'module_listener_options' => [],
        ]);

        $this->moduleLoader->getApplication()->bootstrap();
    }

    public function testHalRendererWithHalEntities()
    {
        /** @var Hal $halPlugin */
        $halPlugin = $this->moduleLoader->getServiceManager()->get('ViewHelperManager')->get('Hal');

        $rootTestEntity = new RootTestEntity();
        $childTestEntity = new ChildTestEntity();

        $rootTestEntity->setChildEntity(new Entity($childTestEntity));
        $rootTestEntity->setUnkownChildEntity(new Entity(new UnkownChildTestEntity()));

        $expectedArray = [
            '_embedded' => [
                'phpunit:test-entity' => [
                    '_links' => [],
                ],
                'unkownChildEntity' => [
                    'unkownChildTestProperty' => 'phpunit',
                    '_links' => [],
                ],
            ],
            '_links' => [],
        ];

        $this->assertSame($expectedArray, $halPlugin->renderEntity(new Entity($rootTestEntity)));
    }

    public function testHalRendererWithConcreteEntities()
    {
        /** @var Hal $halPlugin */
        $halPlugin = $this->moduleLoader->getServiceManager()->get('ViewHelperManager')->get('Hal');

        $rootTestEntity = new RootTestEntity();
        $childTestEntity = new ChildTestEntity();

        $rootTestEntity->setChildEntity($childTestEntity);
        $rootTestEntity->setUnkownChildEntity(new UnkownChildTestEntity());

        $expectedArray = [
            '_embedded' => [
                'phpunit:test-entity' => [
                    '_links' => [],
                ],
                'unkownChildEntity' => [
                    'unkownChildTestProperty' => 'phpunit',
                    '_links' => [],
                ],
            ],
            '_links' => [],
        ];

        $this->assertSame($expectedArray, $halPlugin->renderEntity(new Entity($rootTestEntity)));
    }

    public function testHalRendererUsesCollectionNameWhenProvided()
    {
        /** @var Hal $halPlugin */
        $halPlugin = $this->moduleLoader->getServiceManager()->get('ViewHelperManager')->get('Hal');

        $rootTestEntity = new RootTestEntity();
        $childTestEntity = new ChildTestEntity();

        $childEntityCollection = new Collection([
            $childTestEntity, $childTestEntity
        ]);
        $childEntityCollection->setCollectionName('phpunit:fancy-collection-name');
        $rootTestEntity->setChildEntity($childEntityCollection);
        $rootTestEntity->setUnkownChildEntity(new UnkownChildTestEntity());

        $expectedArray = [
            '_embedded' => [
                'phpunit:fancy-collection-name' => [
                    ['_links' => []],
                    ['_links' => []]
                ],
                'unkownChildEntity' => [
                    'unkownChildTestProperty' => 'phpunit',
                    '_links' => [],
                ],
            ],
            '_links' => [],
        ];

        $this->assertSame($expectedArray, $halPlugin->renderEntity(new Entity($rootTestEntity)));
    }

    public function testHalRendererUsesPropertynameWhenNoSpecificCollectionNameIsSet()
    {
        /** @var Hal $halPlugin */
        $halPlugin = $this->moduleLoader->getServiceManager()->get('ViewHelperManager')->get('Hal');

        $rootTestEntity = new RootTestEntity();
        $childTestEntity = new ChildTestEntity();

        $childEntityCollection = new Collection([
            $childTestEntity, $childTestEntity
        ]);

        $rootTestEntity->setChildEntity($childEntityCollection);
        $rootTestEntity->setUnkownChildEntity(new UnkownChildTestEntity());

        $expectedArray = [
            '_embedded' => [
                'childEntity' => [
                    ['_links' => []],
                    ['_links' => []]
                ],
                'unkownChildEntity' => [
                    'unkownChildTestProperty' => 'phpunit',
                    '_links' => [],
                ],
            ],
            '_links' => [],
        ];

        $this->assertSame($expectedArray, $halPlugin->renderEntity(new Entity($rootTestEntity)));
    }
}
