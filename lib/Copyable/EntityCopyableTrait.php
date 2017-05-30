<?php

/*
 * This file is part of the `src-run/arthur-doctrine-library` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Doctrine\ORM\Mapping\Copyable;

use SR\Doctrine\ORM\Mapping\Reflectable\ReflectionMethodSearch;

trait EntityCopyableTrait
{
    public function __clone()
    {
        if ($this->isCloneSafe()) {
            $this->searchMethods('{^clone}')->invoke();
        }
    }

    /**
     * @return bool
     */
    final public function isCloneSafe(): bool
    {
        return $this->hasIdentity();
    }

    /**
     * @param null|string $search
     *
     * @return ReflectionMethodSearch
     */
    abstract public function searchMethods(string $search = null);
}
