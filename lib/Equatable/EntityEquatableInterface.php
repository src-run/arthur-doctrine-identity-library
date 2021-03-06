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

interface EntityEquatableInterface
{
    /**
     * @param Entity $compareTo
     *
     * @return bool
     */
    public function isEqualTo(Entity $compareTo): bool;

    /**
     * @param Entity $compareTo
     *
     * @return bool
     */
    public function isEqualToIdentity(Entity $compareTo): bool;
}
