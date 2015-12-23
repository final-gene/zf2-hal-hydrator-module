<?php
/**
 * This file is part of the zf-hal-hydrator-module.php project.
 *
 * @copyright Copyright (c) 2015, final gene <info@final-gene.de>
 * @author    Frank Giesecke <frank.giesecke@final-gene.de>
 */

namespace FinalGene\ZfHalHydratorModule\Hydrator\NamingStrategy;

use Zend\Stdlib\Hydrator\NamingStrategy\MapNamingStrategy as ZendMapNamingStrategy;
use ZF\Hal\Collection;
use ZF\Hal\Entity;

/**
 * Class MapNamingStrategy
 *
 * If the value is an object of the type ZF\Hal\Entity, this class extract the real entity (ZF\Hal\Entity::$entity)
 * and uses the classname for the lookup.
 *
 * @package FinalGene\ZfHalHydratorModule\Hydrator\NamingStrategy
 */
class MapNamingStrategy extends ZendMapNamingStrategy
{
    /**
     * @inheritdoc
     */
    public function extract($name)
    {
        /**
         * @var mixed $object contains the object which has the $name property to be extracted from. Even though the
         * interface does not hint that we get this argument, we actually get it.
         * @see Zend\Stdlib\Hydrator\AbstractHydrator::extractName()
         */
        $object = func_get_arg(1);

        if (!is_object($object)) {
            return parent::extract($name);
        }

        $refObject = new \ReflectionObject($object);
        if (!$refObject->hasProperty($name)) {
            return parent::extract($name);
        }

        $refProperty = $refObject->getProperty($name);
        $refProperty->setAccessible(true);

        if ($refProperty->getValue($object) instanceof Entity) {
            $lookupName = get_class($refProperty->getValue($object)->entity);
            if (array_key_exists($lookupName, $this->reverse)) {
                return parent::extract($lookupName);
            }
        } elseif ($refProperty->getValue($object) instanceof Collection) {
            /** @var Collection $collection */
            $collection = $refProperty->getValue($object);

            $refClassCollection = new \ReflectionClass(Collection::class);
            $collectionDefaultProperties = $refClassCollection->getDefaultProperties();

            if (!array_key_exists('collectionName', $collectionDefaultProperties)) {
                throw new \RuntimeException('Can not determine the default value of property collectionName');
            }

            /*
             * If collectionName returns the default value (at zfcampus/zf-hal version 1.2 it's "items")
             * we assume that nobody ever set a collectionName. Therefore, we ignore the collectionName.
             * This leads to the normal behaviour that the array-key used for the collection (after extracting) is the
             * name of the property where the collection was assigned to.
             *
             * If we wouldn't do this and we would try to extract from an object that has property1 and property2
             * containing different collections we would try to put both collections under the default-key ("items").
             * This means after extracting we would have a key "items" which contains only the collection of property2
             * and prop1 is completely missing in the result.
             */
            if ($collectionDefaultProperties['collectionName'] !== $collection->getCollectionName()) {
                return $refProperty->getValue($object)->getCollectionName();
            }
        } elseif (is_object($refProperty->getValue($object))) {
            $lookupName = get_class($refProperty->getValue($object));
            if (array_key_exists($lookupName, $this->reverse)) {
                return parent::extract($lookupName);
            }
        }
        return parent::extract($name);
    }
}
