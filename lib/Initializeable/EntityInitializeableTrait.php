<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Initializeable;

/**
 * Trait EntityInitializeableTrait.
 */
trait EntityInitializeableTrait
{
    /**
     * @return $this
     */
    final protected function doInitialize()
    {
        foreach (self::findMethods('initialize') as $method) {
            $method->setAccessible(true);
            $method->invoke($this);
        }

        return $this;
    }

    /**
     * @param null|string $needle
     * @param bool        $reverse
     *
     * @return \ReflectionMethod[]
     */
    abstract protected function findMethods($needle = null, $reverse = false);
}

/* EOF */
