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

trait EntityEquatableTrait
{
    /**
     * @param Entity $compareTo
     *
     * @return bool
     */
    final public function isEqualTo(Entity $compareTo): bool
    {
        return (new EqualityChecker($this, $compareTo))->isEqual();
    }

    /**
     * @param Entity $compareTo
     *
     * @return bool
     */
    final public function isEqualToIdentity(Entity $compareTo): bool
    {
        return (new EqualityChecker($this, $compareTo))->isIdentityEqual();
    }
}
