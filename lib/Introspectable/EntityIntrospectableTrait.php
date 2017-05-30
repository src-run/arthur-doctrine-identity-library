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

trait EntityIntrospectableTrait
{
    /**
     * @param bool $qualified
     *
     * @return string
     */
    final public function getCalledClassName(bool $qualified = true): string
    {
        return Inspect::using(get_called_class())->name($qualified);
    }

    /**
     * @param bool $qualified
     *
     * @return string
     */
    final public function getParentClassName(bool $qualified = true): string
    {
        return Inspect::using(get_parent_class(get_called_class()))->name($qualified);
    }

    /**
     * @param bool $qualified
     *
     * @return string
     */
    final public function getRootClassName(bool $qualified = true): string
    {
        return Inspect::using(__CLASS__)->name($qualified);
    }
}
