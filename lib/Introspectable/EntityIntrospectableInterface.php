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

interface EntityIntrospectableInterface
{
    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function getCalledClassName(bool $qualified = true): string;

    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function getParentClassName(bool $qualified = true): string;

    /**
     * @param bool $qualified
     *
     * @return string
     */
    public function getRootClassName(bool $qualified = true): string;
}
