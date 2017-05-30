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

trait EntityReflectableTrait
{
    /**
     * @param null|string $search
     *
     * @return ReflectionMethodSearch
     */
    final public function searchMethods(string $search = null)
    {
        return new ReflectionMethodSearch($this, $search);
    }

    /**
     * @param string|null $search
     *
     * @return ReflectionPropertySearch
     */
    final public function searchProperties(string $search = null)
    {
        return new ReflectionPropertySearch($this, $search);
    }
}
