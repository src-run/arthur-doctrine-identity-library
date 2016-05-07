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
 * Trait EntityEquatableTrait.
 */
trait EntityEquatableTrait
{
    /**
     * @param Entity $compareTo
     *
     * @return bool
     */
    final public function isEqualTo(Entity $compareTo)
    {
        $propertiesSelfNorm = [];
        $propertiesCompNorm = [];

        $propertiesSelf = Inspect::thisInstance($this)->properties();
        $propertiesComp = Inspect::thisInstance($compareTo)->properties();

        $visitor = function (array $properties, array &$normalized, $bind) {
            foreach ($properties as $property) {
                $normalized[$property->name()] = $property->value($bind);
            }
        };

        $visitor($propertiesSelf, $propertiesSelfNorm, $this);
        $visitor($propertiesComp, $propertiesCompNorm, $compareTo);

        ksort($propertiesSelfNorm);
        ksort($propertiesCompNorm);

        return $propertiesSelfNorm === $propertiesCompNorm;
    }

    /**
     * @param Entity $compareTo
     *
     * @return bool
     */
    final public function isEqualToIdentity(Entity $compareTo)
    {
        return $this->hasIdentity() && $compareTo->hasIdentity() && $this->getIdentity() === $compareTo->getIdentity();
    }

    /**
     * @return bool
     */
    abstract public function hasIdentity();

    /**
     * @return mixed
     */
    abstract public function getIdentity();
}

/* EOF */
