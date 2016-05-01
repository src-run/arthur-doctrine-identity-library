<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Reflectable;

use SR\Doctrine\ORM\Mapping\Entity;
use SR\Reflection\Inspect;
use SR\Utility\StringInspect;

/**
 * Trait EntityReflectableTrait.
 */
trait EntityReflectableTrait
{
    /**
     * @param Entity       $entity
     * @param string       $search
     * @param {...mixed[]} $parameters
     *
     * @return mixed[]
     */
    final protected function invokeMatching(Entity $entity, $search, ...$parameters)
    {
        $methodReturnSet = [];

        foreach ($this->findMethods($search) as $method) {
            $method->setAccessible(true);
            $methodReturnSet[] = $method->invoke($entity, ...$parameters);
        }

        return $methodReturnSet;
    }

    /**
     * @param null|string $needle
     * @param bool        $reverse
     *
     * @return \ReflectionMethod[]
     */
    final protected function findMethods($needle = null, $reverse = false)
    {
        $_ = function (\ReflectionMethod $reflect, $index, $needle, $reverse) {
            return null === $needle || null !== StringInspect::searchPosition($reflect->getName(), $needle, $reverse);
        };

        return Inspect::this($this->getObjectName(true, true))
            ->filterMethods($_, null, $needle, $reverse);
    }

    /**
     * @param null|string $needle
     * @param bool        $reverse
     *
     * @return \ReflectionProperty[]
     */
    final protected function findProperties($needle = null, $reverse = false)
    {
        $_ = function (\ReflectionProperty $reflect, $index, $needle, $reverse) {
            return null === $needle || null !== StringInspect::searchPosition($reflect->getName(), $needle, $reverse);
        };

        return Inspect::this($this->getObjectName(true, true))
            ->filterProperties($_, null, $needle, $reverse);
    }

    /**
     * @param bool $qualified
     * @param bool $static
     *
     * @return string
     */
    abstract public function getObjectName($qualified = false, $static = false);
}

/* EOF */
