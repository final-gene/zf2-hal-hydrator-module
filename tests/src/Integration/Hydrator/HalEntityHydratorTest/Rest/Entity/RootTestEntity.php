<?php
/**
 * This file is part of the zf-hal-hydrator-module.php project.
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity;

use ZF\Hal\Entity;

/**
 * Class RootTestEntity
 *
 * @package FinalGene\ZfHalHydratorModuleTest\Integration\Hydrator\HalEntityHydratorTest\Rest\Entity
 */
class RootTestEntity
{
    /**
     * @var
     */
    protected $childEntity;

    /**
     * @var
     */
    protected $unkownChildEntity;

    /**
     * Set $unkownChildEntity
     *
     * @param $unkownChildEntity
     *
     * @return $this
     */
    public function setUnkownChildEntity($unkownChildEntity)
    {
        $this->unkownChildEntity = $unkownChildEntity;
        return $this;
    }

    /**
     * Set $childEntity
     *
     * @param $childEntity
     *
     * @return $this
     */
    public function setChildEntity($childEntity)
    {
        $this->childEntity = $childEntity;
        return $this;
    }
}
