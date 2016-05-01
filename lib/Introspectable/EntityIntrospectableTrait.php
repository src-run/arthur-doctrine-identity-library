<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Introspectable;

use SR\Reflection\Inspect;

/**
 * Trait EntityIntrospectableTrait.
 */
trait EntityIntrospectableTrait
{
    /**
     * @param bool $qualified
     * @param bool $static
     *
     * @return string
     */
    final public function getObjectName($qualified = false, $static = false)
    {
        return Inspect::this($static ? get_called_class() : get_class())->name($qualified);
    }

    /**
     * @param bool        $qualified
     * @param null|object $instance
     *
     * @return string
     */
    final public function getParentName($qualified = false, $instance = null)
    {
        return Inspect::this(get_parent_class($instance))->name($qualified);
    }

    /**
     * @return mixed
     */
    abstract public function __toArray();
}

/* EOF */
