<?php
/**
 * This file is part of the zf-hal-hydrator-module.php project.
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package Options
 */
class ModuleOptions extends AbstractOptions
{
    /** @var array */
    protected $map = [];

    /**
     * Get $map
     *
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set $map
     *
     * @param array $map
     *
     * @return $this
     */
    public function setMap(array $map)
    {
        $this->map = $map;
        return $this;
    }
}
