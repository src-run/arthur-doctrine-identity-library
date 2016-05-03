<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Equatable;

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Reflection\Inspect;

/**
 * Interface EntityEquatableInterface.
 */
trait EntityEquatableTrait
{
    /**
     * @param Entity $entityCompare
     *
     * @return bool
     */
    final public function isEqualTo(Entity $entityCompare)
    {
        $propertiesSelfNorm = [];
        $propertiesCompNorm = [];

        $propertiesSelf = Inspect::this($this)->properties();
        $propertiesComp = Inspect::this($entityCompare)->properties();

        $visitor = function (array $properties, array &$normalized, $bind) {
            foreach ($properties as $property) {
                $normalized[$property->name()] = $property->value($bind);
            }
        };

        $visitor($propertiesSelf, $propertiesSelfNorm, $this);
        $visitor($propertiesComp, $propertiesCompNorm, $entityCompare);

        ksort($propertiesSelfNorm);
        ksort($propertiesCompNorm);

        return $propertiesSelfNorm === $propertiesCompNorm;
    }

    /**
     * @param Entity $entity
     *
     * @return bool
     */
    final public function isEqualToIdentity(Entity $entity)
    {
        return $this->getIdentity() !== null && $this->getIdentity() === $entity->getIdentity();
    }

    /**
     * @return mixed
     */
    abstract public function getIdentity();
}

/* EOF */
