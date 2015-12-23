<?php
/**
 * Module test file
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModuleTest\Integration;

use Zend\Test\Util\ModuleLoader;

/**
 * Module test
 *
 * @package FinalGene\ZfHalHydratorModuleTest
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ModuleLoader
     */
    protected $moduleLoader;

    protected function setUp()
    {
        $this->moduleLoader = new ModuleLoader([
            'modules' => [
                'FinalGene\ZfHalHydratorModule',
            ],
            'module_listener_options' => [],
        ]);
    }

    /**
     * Test if the module can be loaded
     */
    public function testModuleIsLoadable()
    {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $this->moduleLoader->getModuleManager();

        $this->assertNotNull(
            $moduleManager->getModule('FinalGene\ZfHalHydratorModule'),
            'Module could not be initialized'
        );
        $this->assertInstanceOf(
            'FinalGene\ZfHalHydratorModule\Module',
            $moduleManager->getModule('FinalGene\ZfHalHydratorModule')
        );
    }
}
