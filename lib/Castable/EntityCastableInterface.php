<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Castable;

interface EntityCastableInterface
{
    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return array
     */
    public function __debugInfo(): array;

    /**
     * @return array[]
     */
    public function __toArray(): array;
}
